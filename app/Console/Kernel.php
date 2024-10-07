<?php

namespace App\Console;

use App\Jobs\FileToDatabaseJob;
use App\Jobs\MakeBoletoJob;
use App\Jobs\SendEmailJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new FileToDatabaseJob)
//            ->weekdays()
            ->everyFiveSeconds()
//            ->between('6:00', '23:00')
        ;

        $schedule->job(new MakeBoletoJob())
//            ->weekdays()
            ->everyFiveSeconds()
//            ->between('6:00', '23:00')
        ;
        $schedule->job(new SendEmailJob())
//            ->weekdays()
            ->everyFiveSeconds()
//            ->between('6:00', '23:00')
        ;

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
