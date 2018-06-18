<?php

namespace Closet\Jobs\Product;

use Closet\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DecreaseProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
      $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $print = [];
      foreach ($this->data as $item) {
        $product = Product::find($item['id']);
        $product->decrement('amount', $item['qty']);
        if ($product->amount <= 0) {
          $product->update(['stock' => false]);
        }
      }
    }
}
