<?php

namespace Closet\Http\Controllers;

use Illuminate\Http\Request;
use Closet\Models\{Discount, Shop};

class PromotionController extends Controller
{
    public function index()
    {
      return view('promotion.index');
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
}
