<?php

namespace Closet\Jobs\Product;

use Image;
use File;
use Storage;
use Closet\Models\ProductImage;
use Closet\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProductUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product;
    protected $thumbnail;
    protected $photos = array();
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product, $thumbnail, array $photos)
    {
        $this->product = $product;
        $this->thumbnail = $thumbnail;
        $this->photos[] = $photos;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ProductImage $img)
    {
      if($this->thumbnail) {
        $file = storage_path() . '/uploads/product/thumbnail/' . $this->thumbnail;
        $background = Image::canvas(200, 200, '#ffffff');
        $img = Image::make($file)->encode('jpg', 10)->fit(200, 200, function ($c) {
            $c->upsize();
            $c->aspectRatio();
        });
        $background->insert($img, 'center');
        $img = $background->stream();
        Storage::disk('s3images')->put('product/thumbnail/' . $this->thumbnail . '.jpg', $img->__toString());
        $this->product->thumbnail = $this->thumbnail . '.jpg';
        $this->product->save();
        unlink($file);
      }
      $photos = array_flatten($this->photos);
      foreach($photos as $photo) {
          $file = storage_path() . '/uploads/product/photo/' . $photo;
          $background = Image::canvas(500, 500, '#ffffff');
          $img = Image::make($file)->encode('jpg')->resize(500, 500, function ($c) {
              $c->aspectRatio();
              $c->upsize();
          });
          $background->insert($img, 'center');
          $img = $background->stream();
          Storage::disk('s3images')->put('product/photo/' . $photo . '.jpg', $img->__toString());

          ProductImage::create([
            'product_id' => $this->product->id,
            'filename' => $photo . '.jpg'
            ]);
          unlink($file);
      }

    }
}
