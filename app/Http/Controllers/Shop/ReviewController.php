<?php

namespace Closet\Http\Controllers\Shop;

use Auth;
use Fractal;
use Closet\Models\{Shop, Feedback, Order};
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Transformer\ReviewTransformer;

class ReviewController extends Controller
{
  public function get(Shop $shop)
  {
    $get = $shop->feedback()->orderBy('points', 'desc')->get();
    $user_review = Feedback::where('giver_id', Auth::id())->get();
    $reviews = Fractal::collection($get)->parseIncludes('shop')->transformWith(new ReviewTransformer);

    $points = [];
    foreach ($get as $value) {
      $points[] = $value['points'];
    }
    $total = array_sum($points);

    $max_points = array_count_values($points);

    $max = [];
    foreach ($max_points as $key => $value) {
      $max[] = $value * 5;
    }
    $max = array_sum($max);

    if ($max !== 0) {
      $percent = ($total / $max) * 100;
    } else {
      $percent = $max;
    }

    return response()->json([
      'reviews' => $reviews,
      'user_review' => $user_review,
      'points' => number_format($percent, 0),
    ]);
  }

  // public function delete(Shop $shop, Feedback $feedback)
  // {
  //   if (Auth::id() === $feedback->giver_id) {
  //     $feedback->delete();
  //   }
  //
  //   return response()->json();
  // }

  public function getTotalReview(Shop $shop)
  {
    $data = $shop->feedback;
    $points = [];
    foreach ($data as $value) {
      $points[] = $value['points'];
    }
    $total = array_sum($points);

    $max_points = array_count_values($points);

    $max = [];
    foreach ($max_points as $key => $value) {
      $max[] = $value * 5;
    }
    $max = array_sum($max);
    if ($max !== 0) {
      $percent = ($total / $max) * 100;
    } else {
      $percent = $max;
    }

    return response()->json(number_format($percent, 0));

  }

}
