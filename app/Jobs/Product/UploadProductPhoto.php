<?php

namespace Closet\Jobs\Product;

use Image;
use Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UploadProductPhoto implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $photos;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($photos)
    {
      $this->photos = $photos;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      foreach ($this->photos as $photo) {
          $path = storage_path('/uploads/product/photo/') . $photo;
          $background = Image::canvas(500, 500, '#ffffff');
          $img = Image::make($path)->encode('jpg')->resize(500, 500, function ($c) {
              $c->aspectRatio();
              $c->upsize();
          });

          $background->insert($img, 'center');
          $img = $background->stream();
          Storage::disk('s3images')->put('product/photo/' . $photo . '.jpg', $img->__toString());
          unlink($path);
      }
    }
}
