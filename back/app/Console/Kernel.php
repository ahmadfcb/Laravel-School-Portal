<?php

namespace App\Console;

use App\Console\Commands\GenerateFeeFineAfterDueDateCommand;
use App\Console\Commands\GenerateMonthlyFeeCommand;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule( Schedule $schedule )
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command( GenerateMonthlyFeeCommand::class )->monthlyOn( 1 );

        $schedule->command( GenerateFeeFineAfterDueDateCommand::class )->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load( __DIR__ . '/Commands' );

        require base_path( 'routes/console.php' );
    }
}
