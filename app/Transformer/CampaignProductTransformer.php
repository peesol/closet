<?php

namespace Closet\Transformer;

use Closet\Models\{Product, CampaignProduct};
use League\Fractal\TransformerAbstract;

class CampaignProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
      return [
        'id' => $product->id,
        'uid' => $product->uid,
        'name' => $product->name,
        'price' => $product->price,
        'discount_price' => $product->discount_price,
        'in_campaign' => (bool) $product->campaign()->exists(),
        'campaign' => $product->campaign()->value('campaign'),
      ];
    }
}
