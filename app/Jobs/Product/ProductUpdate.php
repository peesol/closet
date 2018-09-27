<?php

namespace Closet\Jobs\Product;

use Image;
use Storage;
use Closet\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProductUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;
    public $fileName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Product $product, $fileName)
    {
        $this->product = $product;
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $local_path = storage_path('uploads/product/thumbnail/') . $this->fileName;

      $background = Image::canvas(200, 200, '#ffffff');
      $img = Image::make($local_path)->encode('jpg', 10)->resize(200, 200, function ($c) {
          $c->upsize();
          $c->aspectRatio();
      });
      $background->insert($img, 'center');
      $img = $background->stream();

      Storage::disk('s3images')->put('product/thumbnail/' . $this->fileName . '.jpg', $img->__toString());

      unlink($local_path);

      $this->product->thumbnail = $this->fileName . '.jpg';
      $this->product->save();
    }
}
