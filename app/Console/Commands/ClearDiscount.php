<?php

namespace Closet\Console\Commands;

use Closet\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearDiscount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set expired discount to null';

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
        $time = Carbon::now('Asia/Bangkok')->subDays(30)->toDateTimeString();

        $data = Product::where('discount_date', '<=', $time);

        $updated = [];
        foreach ($data->get() as $value) {
          $updated[] = $value->id;
        }

        $data->update([
          'discount_price' => null,
          'discount_date' => null,
        ]);

        Product::find($updated)->searchable();

        $this->info('All discounts are cleared!!!');
    }
}
