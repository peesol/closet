<?php

namespace Closet\Http\Controllers\Report;

use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\{Product, Shop, Report};

class ReportController extends Controller
{
  public function productView(Product $product)
  {
    return view('report.product', [
      'product' => $product
    ]);
  }
  public function shopView(Shop $shop)
  {
    return view('report.shop', [
      'shop' => $shop
    ]);
  }
  public function productCreate(Product $product, Request $request)
  {
    $product->reports()->create([
      'user_id' => $request->user()->id,
      'body' => $request->body,
      'title' => $request->title
    ]);

    return redirect()->route('reportSuccess');
  }
  public function shopCreate(Shop $shop, Request $request)
  {
    $shop->reports()->create([
      'user_id' => $request->user()->id,
      'body' => $request->body,
      'title' => $request->title
    ]);

    return redirect()->route('reportSuccess');
  }

  public function success()
  {
    return view('report.success');
  }

}
