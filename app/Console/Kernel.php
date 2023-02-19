<?php

namespace App\Console;

use App\Jobs\ProcessIncomingEmail;
use App\Models\Inbox;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('telescope:prune --hours=48')->daily();

        $schedule->call(function () {
            Inbox::all()->each(function ($inbox) {
                ProcessIncomingEmail::dispatch($inbox)->onQueue('email');
            });
        })->everyFifteenMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
