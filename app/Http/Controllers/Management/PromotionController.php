<?php

namespace Closet\Http\Controllers\Management;

use DB;
use Date;
use Fractal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\{Discount, Shop, Product};
use Closet\Transformer\{DiscountProductTransformer, CampaignProductTransformer};

class PromotionController extends Controller
{
  public function index(Request $request)
  {
    $promotions = $request->user()->shop->promotion_points;

    return view('promotion.index', ['points' => json_decode($promotions, true)]);
  }

  public function getShopPromotion(Request $request)
  {
    $promotions = $request->user()->shop->promotion_points;
    return response()->json($promotions);
  }

  //Discount Codes
  public function codePage(Request $request)
  {
    return view('promotion.code');
  }

  public function getCodes(Request $request)
  {
    $codes = $request->user()->shop->code;
    return response()->json($codes);
  }

  public function createCode(Request $request)
  {
    $check = DB::table('discounts')->where([
      ['shop_id', $request->user()->id],
      ['code', $request->code]
    ])->get();

    if (count($check)) {
      return response(__('message.code_exist'), 406);
    } else {
      $code = $request->user()->shop->code()->create([
        'code' => $request->code,
        'discount' => $request->discount,
        'type' => $request->type,
        'amount' => $request->amount,
      ]);
      return response()->json($code);
    }
  }

  public function removeCode(Request $request, Discount $discount)
  {
    $discount->delete();
    return response()->json();
  }

  public function validateCode(Request $request)
  {
    $match = DB::table('discounts')->where(['code' => $request->code, 'shop_id' => $request->shop_id])->first();
    if ($match) {
      return response()->json([
        'status' => true,
        'type' => $match->type,
        'discount' => $match->discount,
      ]);
    } else {
      return response()->json(false, 200);
    }
  }

  //Product Discount
  public function discountPage(Request $request)
  {
    $promotions = $request->user()->shop->promotion_points;
    return view('promotion.discount', [
      'points' => json_decode($promotions, true),
    ]);
  }
  public function getProduct(Request $request)
  {
    $products = DB::table('products')->where([
      ['shop_id', $request->user()->id],
      ['discount_price', null]
    ])->get();

    $discount = $request->user()->products->where('discount_price','!==', null);
    $discount = Fractal::collection($discount, new DiscountProductTransformer());

    return response()->json([
      'products' => $products,
      'discount_products' => $discount
    ]);
  }
  public function applyDiscount(Product $product, Request $request)
  {
    $this->authorize('update', $product);

    $amount = json_decode($request->user()->shop->promotion_points, true);
    if ($amount['discount'] < 1) {
      return response()->json(false, 406);
    } else {
      $request->user()->shop()->update(['promotion_points->discount' => $amount['discount'] - 1]);
      $target = $product->update([
        'discount_price' => $product->price - $request->discount,
        'discount_date' => Carbon::now('Asia/Bangkok')->addMonths(+1)
      ]);

      return response()->json([
        'name' => $product->name,
        'price' => $product->price,
        'uid' => $product->uid,
        'discount_price' => $product->discount_price,
        'discount_date' => $product->discount_date->format('d-m-Y')
      ]);
    }
  }
  public function removeDiscount(Product $product)
  {
    $this->authorize('update', $product);
    $product->update([
      'discount_price' => null,
      'discount_date' => null
    ]);
    return response()->json(null, 200);
  }

  // Campaign
  public function campaignPage(Request $request)
  {
    $promotions = $request->user()->shop->promotion_points;
    $data = DB::table('campaigns')->get();
    return view('promotion.campaign', [
      'campaigns' => $data,
      'points' => json_decode($promotions, true)
    ]);
  }

  public function getCampaignProduct(Request $request)
  {
    $data = Product::where('shop_id', $request->user()->id)->latestFirst()->get();
    $products = Fractal::collection($data, new CampaignProductTransformer());

    return response()->json($products);
  }

  public function addToCampaign(Product $product, Request $request)
  {
    $this->authorize('update', $product);

    $amount = json_decode($request->user()->shop->promotion_points, true);
    if ($amount['campaign'] < 1) {
      return response()->json(false, 406);
    } else {
      if (!$product->campaign()->exists()) {
        $request->user()->shop()->update(['promotion_points->campaign' => $amount['campaign'] - 1]);
        DB::table('campaign_products')->insert([
          'shop_id' => $product->shop_id,
          'product_id' => $product->id,
          'campaign_id' => $request->campaign_id
        ]);
        $rule =  DB::table('campaigns')->where('id', $request->campaign_id)->value('rules->price');
        if ($rule != 'null') {
          $product->update([
            'discount_price' => $rule,
            'discount_date' => Carbon::now('Asia/Bangkok')->addMonths(+1)
          ]);
        }
        return $rule;
      } else {
        return response(__('message.campaign_exist'), 406);
      }
    }
  }

  public function removeFromCampaign(Request $request, Product $product)
  {
    $this->authorize('update', $product);
    $product->update([
      'discount_price' => null,
      'discount_date' => null
    ]);

    DB::table('campaign_products')->where('product_id', $product->id)->delete();
  }
}
