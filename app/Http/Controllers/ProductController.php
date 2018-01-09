<?php

namespace Closet\Http\Controllers;

use App;
use Storage;
use Image;
use Fractal;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Closet\Jobs\Product\{ProductUpload, UploadProductPhoto, ProductUpdate};
use Closet\Jobs\Images\DeleteImage;
use Closet\Http\Requests\ProductListingRequest;
use Closet\Transformer\ProductImageTransformer;
use Closet\Models\{Product,ProductImage,ProductChoice,Category,Subcategory,CategoryType,Translation, Shop};


class ProductController extends Controller
{
    public function show(Product $product)
    {
        return view('product.show', [
          'product' => $product,
      ]);
    }
    public function productAjax(Product $product)
    {
      return response()->json($product);
    }
    public function choiceAjax(Product $product)
    {
      $choices = $product->choices()->get();

      return response()->json($choices);
    }
    public function userProduct(Request $request)
    {
      $products = $request->user()->products()->latestFirst()->paginate(10);

      return view('product.myproduct', ['products' => $products]);
    }

    public function create(Request $request)
    {
      if ($request->user()->canSell()) {
        return view('product.sell');
      } else {
        return view('product.cant_sell', ['shop' => $request->user()->shop]);
      }
    }
    public function getCategory(Category $category,Translation $translate)
    {
      $lang = App::getLocale();
      if($lang == 'en'){
        $category = $category->get();
      }
      if($lang == 'th') {
        $category = $category->select(['id', 'name'])->with(array('translate' => function($query) use ($lang) {$query->where('language', $lang);}))->get();
      }
      return response()->json($category);
    }

    public function getSubcategory($categoryId)
    {
      $lang = App::getLocale();
      if($lang == 'en') {
        $subcategories = Subcategory::where('category_id', '=', $categoryId)->get();
      }
      if($lang == 'th') {
        $subcategories = Subcategory::where('category_id', '=', $categoryId)->with(array('translate' => function($query) use ($lang) {$query->where('language', $lang);}))->get();
      }
      return response()->json($subcategories);
    }

    public function getType($subcategoryId)
    {
      $lang = App::getLocale();
      if($lang == 'en'){
        $types = CategoryType::where('subcategory_id', '=', $subcategoryId)->get();
      }
      if($lang == 'th'){
        $types = CategoryType::where('subcategory_id', '=', $subcategoryId)->with(array('translate' => function($query) use ($lang) {$query->where('language', $lang);}))->get();
      }

      return response()->json($types);
    }

    public function store(Request $request,Product $product,ProductImage $productimage)
    {
      $type_id = $request->type_id == 'null' ? '1' : $request->type_id;
      $uid = uniqid('p_');
      $shop = $request->user()->shop()->first();
      $product = $shop->product()->create([
        'uid' => $uid,
        'name' => $request->name,
        'category_id' => $request->category_id,
        'subcategory_id' => $request->subcategory_id,
        'type_id' => $type_id,
        'price' => $request->price,
        'description' => $request->description,
        'visibility' => $request->visibility,
        'thumbnail' => '',
      ]);

      $images =  $request->file('image');
      if($images[0]) {
        $thumbnail = uniqid('p_thumb_');
        Storage::disk('uploads')->putFileAs('product/thumbnail/', $images[0], $thumbnail);
      }
      foreach ($images as $image) {
        $photo = uniqid('p_img_');
        Storage::disk('uploads')->putFileAs('product/photo/', $image, $photo);
        $photos[] = $photo;
      }

      $this->dispatch(new ProductUpload($product, $thumbnail, $photos));

      return response()->json();
    }

    public function delete(Product $product)
    {
      $this->authorize('delete', $product);
        $path = 'product/thumbnail/' . $product->thumbnail;
        $this->dispatch(new DeleteImage($path));
      foreach ($product->productimages as $image) {
        $path = 'product/photo/' . $image->filename;
        $this->dispatch(new DeleteImage($path));
      }
      $product->delete();

      return redirect()->back();
    }

    public function edit(Product $product)
    {
      $this->authorize('edit', $product);

      return view('product.settings.edit_vue', [

        'product' => $product,

        ]);
    }
    public function getPhoto(Product $product)
    {
      return response()->json(
           Fractal::collection($product->productimages()->get())
                ->transformWith(new ProductImageTransformer)
                ->toArray()
                );
    }

    public function uploadPhoto(Request $request, Product $product, $id)
    {
        if(ProductImage::where('product_id', $id)->count() < 7){
          $photos = [];
          foreach ($request->file('image') as $image) {
            $photo = uniqid('p_img_');
            Storage::disk('uploads')->putFileAs('product/photo/', $image, $photo);
            $photos[] = $photo;
            ProductImage::create([
                'product_id' => $id,
                'filename' => $photo . '.jpg'
            ]);
          }
          $this->dispatch(new UploadProductPhoto($photos));

        } else {
          return false;
        }
    }

    public function update(Request $request, Product $product)
    {
      $this->authorize('update', $product);

      $update = $product->update([
        'product_name' => $request->name,
        'price' => $request->price,
        'description' => $request->description,
        'visibility' => $request->visibility,
      ]);

      if (!empty($request->thumbnail)) {

          if (!empty($product->thumbnail)) {
            $path = 'product/thumbnail/' . $product->thumbnail;
            $this->dispatch(new DeleteImage($path));
          }
          $thumbnail = $request->thumbnail;
          $fileName = uniqid('p_thumb');
          $this->dispatch(new ProductUpdate($product, $thumbnail, $fileName));
      }

      return response()->json(null, 200);
    }

    public function updateShipping(Request $request,Product $product)
    {
      $this->authorize('update', $product);

      $update = $product->update([
        'shipping' => $request->shipping,
        'shipping_free' => $request->shipping_free,
        'shipping_fee' => $request->shipping_fee,
        'shipping_time' => $request->shipping_time,
        'shipping_inter' => $request->shipping_inter,
      ]);
      return response()->json(null, 200);
    }

    public function shippingIndex(Request $request)
    {
      $shop = $request->user()->shop->get();

      return view('product.settings.shipping', [
        'shop' => $shop
      ]);

    }

    public function shippingEditAll(Request $request, Product $product)
    {
      $products = $product->where('shop_id', $request->user()->shop->id);

      $products->update([
        'shipping' => $request->shipping,
        'shipping_free' => $request->shipping_free,
        'shipping_fee' => $request->shipping_fee,
        'shipping_time' => $request->shipping_time,
        'shipping_inter' => $request->shipping_inter,
      ]);

      return response()->json(null, 200);
    }

    public function deletePhoto(ProductImage $product,$id)
    {
        $photo = ProductImage::find($id);
        $path = 'product/photo/' . $photo->filename;
        $this->dispatch(new DeleteImage($path));
        $photo->delete();

        return response()->json(null, 200);
    }

    public function getChoice(ProductChoice $choice, $productId)
    {
        $choices = $choice->where('product_id', $productId)->get();

        return response()->json($choices);
    }

    public function addChoice(Request $request, ProductChoice $choice, $productId)
    {
        $choice->create([
          'product_id' => $productId,
          'name' => $request->name,
          'stock' => true,
        ]);

        return response()->json(null, 200);
    }

    public function toggleChoice(Request $request, ProductChoice $choice)
    {
      $target = $choice->find($request->id);
        if ($target->stock == true) {
          $target->update(['stock' => false]);
        } else {
          $target->update(['stock' => true]);
        }

        return response()->json(null, 200);
    }

    public function removeChoice(Request $request, ProductChoice $choice, $id)
    {
        $choice->find($id)->delete();

        return response()->json(null, 200);
    }

    public function logView(Request $request, Product $product)
    {
        /*$ip = $request->ip();
         *$user = $request->user() ? $request->user()->id : null;
         *$user_view = $product->views()->create([
         * 'user_id' => $user,
         * 'product_id' => $request->product_id,
         * 'ip' => $ip
         * ]);
        */
      $request->product->increment('view_count');
      return response()->json(null, 200);
    }


}
