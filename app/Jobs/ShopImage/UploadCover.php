<?php

namespace Closet\Jobs\ShopImage;

use Image;
use Closet\Models\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UploadCover implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $shop;
    public $cover;
    public $fileName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Shop $shop, $cover, $fileName)
    {
      $this->shop = $shop;
      $this->cover = $cover;
      $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $exploded = explode(',', $this->cover);

      $decoded = base64_decode($exploded[1]);

      $local_path = storage_path('uploads/profile/cover/') . $this->fileName;

      file_put_contents($local_path, $decoded);

      $background = Image::canvas(1100, 315, '#ffffff');
      $img = Image::make($local_path)->encode('jpg')->resize(1100, 315, function ($c){
          $c->aspectRatio();
          $c->upsize();
      });
      $background->insert($img, 'center');
      $img = $background->stream();
      Storage::disk('s3images')->put('profile/cover/' . $this->fileName . '.jpg', $img->__toString());
      unlink($local_path);

      $this->shop->cover = $this->fileName . '.jpg';
      $this->shop->save();
    }
}
