<?php

namespace Closet\Console\Commands;

use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Closet\Jobs\Images\DeleteImage;

class RemoveUsed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'used:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all used products';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $thumbnails = DB::table('used_products')->where('created_at', '<=', Carbon::now()->subDays(30))->pluck('thumbnail');
        $images = DB::table('used_product_images')->where('created_at', '<=', Carbon::now()->subDays(30))->pluck('filename');

        
        foreach ($thumbnails as $thumbnail) {
          $path = 'used/thumbnail/' . $thumbnail;
          dispatch(new DeleteImage($path));
        }

        foreach ($images as $image) {
          $path = 'used/photo/' . $image;
          dispatch(new DeleteImage($path));
        }

        DB::table('used_products')->where('created_at', '<=', Carbon::now())->delete();
        $this->info('All expired used products have been removed!!!');
    }
}
