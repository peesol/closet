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

    public $fileName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileName)
    {
      $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


      $path = storage_path('uploads/profile/cover/') . $this->fileName;

      $background = Image::canvas(1100, 315, '#ffffff');
      $img = Image::make($path)->encode('jpg')->resize(1100, 315, function ($c){
          $c->aspectRatio();
          $c->upsize();
      });
      $background->insert($img, 'center');
      $img = $background->stream();
      Storage::disk('s3images')->put('profile/cover/' . $this->fileName . '.jpg', $img->__toString());

      unlink($path);
    }
}
