<?php

namespace Closet\Http\Controllers\Product\Comment;

use Fractal;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\{UsedProduct, Comment};
use Closet\Transformer\CommentTransformer;
use Closet\Http\Requests\CreateProductCommentRequest;

class UsedProductCommentController extends Controller
{
  public function index(UsedProduct $product)
  {
    return response()->json(

      Fractal::collection($product->comments()->latestFirst()->get())
          ->parseIncludes(['shop', 'replies', 'replies.shop'])
          ->transformWith(new CommentTransformer)
          ->toArray()

      );
  }

  public function create(CreateProductCommentRequest $request,UsedProduct $product)
  {
    $comment = $product->comments()->create([
      'body' => $request->body,
      'reply_id' => $request->get('reply_id', null),
      'user_id' => $request->user()->id,
      ]);

    return response()->json(

    Fractal::item($comment)
        ->parseIncludes(['shop', 'replies', 'replies.shop'])
        ->transformWith(new CommentTransformer)
        ->toArray()
    );
  }

  public function delete(UsedProduct $product, Comment $comment)
  {
      $this->authorize('delete', $comment);

      $comment->delete();

      return response()->json(null, 200);
  }
}
