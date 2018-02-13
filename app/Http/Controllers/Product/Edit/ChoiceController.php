<?php

namespace Closet\Http\Controllers\Product\Edit;

use Illuminate\Http\Request;
use Closet\Models\{Product, ProductChoice};
use Closet\Http\Controllers\Controller;

class ChoiceController extends Controller
{
  public function get(Product $product)
  {
      $choices = $product->choices;

      return response()->json($choices);
  }

  public function create(Request $request, Product $product)
  {
      $created = $product->choices()->create([
        'name' => $request->name,
        'stock' => true,
      ]);

      return response()->json($created);
  }

  public function toggle(Request $request, Product $product)
  {
    $target = ProductChoice::find($request->id);
      if ($target->stock === true) {
        $target->update(['stock' => false]);
      } else {
        $target->update(['stock' => true]);
      }

      return response()->json(null, 200);
  }

  public function remove(Request $request, ProductChoice $choice, Product $product, $id)
  {
      $choice->find($id)->delete();

      return response()->json(null, 200);
  }
}
