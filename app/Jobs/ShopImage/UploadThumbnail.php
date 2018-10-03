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

class UploadThumbnail implements ShouldQueue
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
      $path = storage_path('uploads/profile/thumbnail/'. $this->fileName);

      $img = Image::make($path)->encode('jpg')->fit(100, 100, function ($c){
          $c->upsize();
      });

      $img = $img->stream();

      Storage::disk('s3images')->put('profile/thumbnail/' . $this->fileName . '.jpg', $img->__toString());

      unlink($path);
    }
}
