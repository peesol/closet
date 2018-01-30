<?php

namespace Closet\Jobs\Product;

use Image;
use File;
use Storage;
use Closet\Models\UsedProductImage;
use Closet\Models\UsedProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UsedUpload implements ShouldQueue
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
    public function handle()
    {
      if($this->thumbnail) {
        $file = storage_path() . '/uploads/used/thumbnail/' . $this->thumbnail;
        $background = Image::canvas(200, 200, '#ffffff');
        $img = Image::make($file)->encode('jpg')->resize(200, 200, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        $background->insert($img, 'center');
        $img = $background->stream();
        Storage::disk('s3images')->put('used/thumbnail/' . $this->thumbnail . '.jpg', $img->__toString());
        $this->product->thumbnail = $this->thumbnail . '.jpg';
        $this->product->save();
        unlink($file);
      }
      $photos = array_flatten($this->photos);
      foreach($photos as $photo) {
          $file = storage_path() . '/uploads/used/photo/' . $photo;
          $background = Image::canvas(500, 500, '#ffffff');
          $img = Image::make($file)->encode('jpg')->resize(500, 500, function ($c) {
              $c->aspectRatio();
              $c->upsize();
          });
          $background->insert($img, 'center');
          $img = $background->stream();
          Storage::disk('s3images')->put('used/photo/' . $photo . '.jpg', $img->__toString());

          UsedProductImage::create([
            'product_id' => $this->product->id,
            'filename' => $photo . '.jpg'
            ]);
          unlink($file);
      }
    }
}
