<?php

namespace Closet\Http\Controllers\Product\Comment;

use Fractal;
use Illuminate\Http\Request;
use Closet\Models\{Comment, Product, User};
use Closet\Http\Controllers\Controller;
use Closet\Transformer\CommentTransformer;
use Closet\Notifications\Seller\Commented;
use Closet\Http\Requests\CreateProductCommentRequest;

class NewProductCommentController extends Controller
{
    public function index(Product $product)
    {
    	return response()->json(

    		Fractal::collection($product->comments()->latestFirst()->get())
    				->parseIncludes(['shop', 'replies', 'replies.shop'])
    				->transformWith(new CommentTransformer)
    				->toArray()

    		);
    }

    public function create(CreateProductCommentRequest $request, Product $product)
    {
    	$comment = $product->comments()->create([
    		'body' => $request->body,
    		'reply_id' => $request->get('reply_id', null),
    		'user_id' => $request->user()->id,
    		]);

        $reciever = User::find($product->shop_id);

        if ($reciever->where('options->comments', true) && $request->user()->id !== $product->shop_id) {
          $reciever->notify(new Commented($product->name));
        }

    	return response()->json(

    	Fractal::item($comment)
    			->parseIncludes(['shop', 'replies', 'replies.shop'])
    			->transformWith(new CommentTransformer)
    			->toArray()
    	);
    }

    public function delete(Product $product, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json(null, 200);
    }
}
