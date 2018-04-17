<?php

namespace Closet\Transformer;

use App;
use Date;
use Closet\Models\Comment;
use League\Fractal\TransformerAbstract;


class CommentTransformer extends TransformerAbstract
{
	protected $availableIncludes = [
		'shop', 'replies'
	];

	public function transform(Comment $comment)
	{
		Date::setLocale(App::getLocale());
		return [
		'id' => $comment->id,
		'user_id' => $comment->user_id,
		'body' => $comment->body,
		'created_at' => $comment->created_at->toDateTimeString(),
		'created_at_human' => Date::parse($comment->created_at)->diffForHumans(),
		];
	}

	public function includeShop(Comment $comment)
	{
		return $this->item($comment->user->shop, new ShopTransformer);
	}

	public function includeReplies(Comment $comment)
	{
		return $this->collection($comment->replies, new CommentTransformer);
	}
}
