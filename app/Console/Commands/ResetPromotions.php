<?php

namespace Closet\Console\Commands;

use DB;
use Illuminate\Console\Command;

class ResetPromotions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotion:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all users promotion_points';

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
      $user = DB::table('shops')->update([
        'promotion_points' => json_encode([
          'discount' => 3,
          'campaign' => 2,
          'flash_sale' => 2,
        ])
      ]);

      $this->info('All promotions are reset!!!');
    }
}
