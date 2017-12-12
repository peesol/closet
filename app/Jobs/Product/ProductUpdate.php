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
    public $thumbnail;
    public $fileName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Product $product, $thumbnail, $fileName)
    {
        $this->product = $product;
        $this->thumbnail = $thumbnail;
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $exploded = explode(',', $this->thumbnail);

      $decoded = base64_decode($exploded[1]);

      $local_path = storage_path('uploads/product/thumbnail/') . $this->fileName;

      file_put_contents($local_path, $decoded);

      $img = Image::make($local_path)->encode('jpg')->fit(200, 200, function ($c){
          $c->upsize();
      });

      $img = $img->stream();

      Storage::disk('s3images')->put('product/thumbnail/' . $this->fileName . '.jpg', $img->__toString());

      unlink($local_path);

      $this->product->thumbnail = $this->fileName . '.jpg';
      $this->product->save();
    }
}
