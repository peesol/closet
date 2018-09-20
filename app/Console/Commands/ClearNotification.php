<?php

namespace Closet\Console\Commands;

use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear outdated or mark as read notifications';

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
      $sevenDays = Carbon::now('Asia/Bangkok')->subDays(7)->toDateTimeString();
      $day = Carbon::now('Asia/Bangkok')->subDays(1)->toDateTimeString();

      $data = DB::table('notifications')->where('read_at', '<=', $day)->orWhere([
          ['read_at', null],
          ['created_at', '<=', $sevenDays]
        ]);

      $data->delete();

      $this->info('All discounts are cleared!!!');
    }
}
