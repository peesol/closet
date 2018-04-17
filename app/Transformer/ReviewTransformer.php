<?php

namespace Closet\Transformer;

use Closet\Models\Feedback;
use League\Fractal\TransformerAbstract;

class ReviewTransformer extends TransformerAbstract
{
  protected $availableIncludes = [ 'shop' ];
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Feedback $review)
    {
        return [
          'points' => $review->points,
          'comment' => $review->comment,
          'giver_id' => $review->giver_id,
        ];
    }

    public function includeShop(Feedback $review)
    {
      return $this->item($review->giver, new ShopTransformer);
    }
}
