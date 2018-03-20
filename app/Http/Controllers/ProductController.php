<?php

namespace Closet\Http\Controllers;

use App;
use Storage;
use Cache;
use Image;
use Fractal;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Closet\Jobs\Product\{ProductUpload, UploadProductPhoto, ProductUpdate};
use Closet\Jobs\Images\DeleteImage;
use Closet\Http\Requests\ProductListingRequest;
use Closet\Models\{Product,ProductImage,ProductChoice,Category,Subcategory,CategoryType,Translation, Shop, Note};


class ProductController extends Controller
{
    public function show(Product $product)
    {
      $contacts = $product->contactsProduct();
      $noted = Note::where(['product_id' => $product->id, 'shop_id' => Auth::user()->id])->count();

        return view('product.show', [
          'product' => $product,
          'contacts' => $contacts,
          'noted' => $noted,
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

    public function getCategory(Category $category,Translation $translate)
    {
      $lang = App::getLocale();
      $data = Cache::get('categories');
      $categories = [];
      foreach ($data as $category) {
        $categories[] = $category->showTranslate($lang);
      }
      return response()->json($categories);
    }

    public function getSubcategory($categoryId)
    {
      $lang = App::getLocale();
      //$data = Subcategory::where('category_id', $categoryId)->get();
      $data = Cache::get('subcategories')->where('category_id', $categoryId);
      $subcategories = [];
      foreach ($data as $subcategory) {
        $subcategories[] = $subcategory->showTranslate($lang);
      }
      return response()->json($subcategories);
    }

    public function getType($subcategoryId)
    {
      $lang = App::getLocale();
      $data = Cache::get('types')->where('subcategory_id', $subcategoryId);
      $types = [];
      foreach ($data as $type) {
        $types[] = $type->showTranslate($lang);
      }
      return response()->json($types);
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
    public function reportPage(Product $product)
    {
      return view('report.product', [
        'product' => $product
      ]);
    }


}
