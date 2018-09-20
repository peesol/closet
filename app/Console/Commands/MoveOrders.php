<?php

namespace Closet\Console\Commands;

use DB;
use Carbon\Carbon;
use Closet\Models\Order;
use Illuminate\Console\Command;

class MoveOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Soft delete all outdated orders';

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
      $shipped = Carbon::now('Asia/Bangkok')->subDays(7)->toDateTimeString();
      $ignored = Carbon::now('Asia/Bangkok')->subDays(3)->toDateTimeString();

      DB::table('orders')->where([
        ['updated_at', '<=', $shipped],
        ['shipped', '=', true],
      ])->delete();

      DB::table('orders')->where([
        ['updated_at', '<=', $ignored],
        ['trans', '=', false],
        ['shipped', '=', false],
      ])->delete();

      $this->info('Orders deleted!!!');
    }
}
