<?php

namespace Closet\Http\Controllers;
use Illuminate\Http\Request;
use Closet\Models\{Discount, Shop, Product};

class PromotionController extends Controller
{
    public function index(Request $request)
    {
      $promotions = $request->user()->shop->availablePromotions;
      return view('promotion.index',['points' => $promotions]);
    }
    public function getShopPromotion(Request $request)
    {
      $promotions = $request->user()->shop->availablePromotions;
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
      $code = $request->user()->shop->code()->create([
        'code' => $request->code,
        'discount' => $request->discount,
        'type' => $request->type,
        'amount' => $request->amount,
      ]);
      return response()->json($code);
    }
    public function removeCode(Request $request, Discount $discount)
    {
      $discount->delete();
      return response()->json();
    }
    public function validateCode(Request $request, Discount $discount)
    {
      $match = Discount::where(['code' => $request->code, 'shop_id' => $request->shop_id])->first();
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
      $promotions = $request->user()->shop->availablePromotions;
      return view('promotion.discount', [
        'promotions' => $promotions,
      ]);
    }
    public function getProduct(Request $request)
    {
      $products = $request->user()->shop->product->where('discount_price', null);
      $discount = $request->user()->shop->product->where('discount_price','!==', null);
      return response()->json([
        'products' => $products,
        'discount_products' => $discount
      ]);
    }
    public function applyDiscount(Product $product, Request $request)
    {
      $amount = $request->user()->shop->availablePromotions->discount;
      if ($amount === 0) {
        return response()->json(false, 200);
      } else {
        $request->user()->shop->availablePromotions->decrement('discount', 1);
        $target = $product->update(['discount_price' => $product->price - $request->discount]);
        return response()->json($product);
      }
    }
    public function removeDiscount(Product $product)
    {
      $product->update(['discount_price' => null]);
      return response()->json(null, 200);
    }
}
