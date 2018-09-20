<?php

namespace Closet\Console;

use DB;
use DateTime;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Closet\Console\Commands\ClearDiscount::class,
        \Closet\Console\Commands\CacheCategory::class,
        \Closet\Console\Commands\RemoveUsed::class,
        \Closet\Console\Commands\IndexProduct::class,
        \Closet\Console\Commands\MoveOrders::class,
        \Closet\Console\Commands\ClearNotification::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('discount:clear')->daily()->timezone('Asia/Bangkok');
        $schedule->command('used:clear')->daily()->timezone('Asia/Bangkok');
        $schedule->command('orders:clear')->daily()->timezone('Asia/Bangkok');
        $schedule->command('notifications:clear')->daily()->timezone('Asia/Bangkok');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
