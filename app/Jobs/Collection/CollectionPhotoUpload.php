<?php

namespace Closet\Jobs\Collection;

use Image;
use Storage;
use Closet\Models\CollectionImage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CollectionPhotoUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $images;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($images)
    {
        $this->images = $images;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->images as $image) {

          $local_path = storage_path('uploads/collection/photo/') . $image;

          $background = Image::canvas(880, 495, '#000000');
          $img = Image::make($local_path)->resize(880, 495, function ($c) {
            $c->aspectRatio();
            $c->upsize();
          });
          $background->insert($img, 'center');
          $img = $background->stream();

          Storage::disk('s3images')->put('collection/photo/' . $image . '.jpg', $img->__toString());
          unlink($local_path);
        }
    }
}
