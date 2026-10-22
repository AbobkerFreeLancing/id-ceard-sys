<?php

namespace App\Console;

use App\Console\Commands\ProductExpireCommand;
use App\Jobs\ProductHasExpiredJob;
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
        ProductExpireCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Sundays=0, mondays=1, thursdays=4
        // $schedule->command('bedaya:product-expire')->everyMinute();
        // -------------
        // $schedule->command('bedaya:product-expire')->weekly()->days([0,2,4,6])->at('11:00');
        // $schedule->command('backup:run')->weekly()->days([0,2,4,6])->at('11:00');
        // $schedule->command('backup:clean')->weekly()->days([0,2,4,6])->at('11:00');
        // 
        $schedule->command('queue:work --stop-when-empty')->everyThreeMinutes()->withoutOverlapping(15*60);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
