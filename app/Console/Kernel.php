<?php

namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Settings;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\ProcessInvestmentRoi::class,
        \App\Console\Commands\CleanupOldNotifications::class,
         \App\Console\Commands\UpdateCryptoPrices::class,
          \App\Console\Commands\UpdateMarketInstruments::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('update:crypto')->everyTenMinutes();
        $schedule->command('update:market')->everyTenMinutes();
        // $schedule->command('market:prices')->everyFiveMinutes();
        // $schedule->command('copytrade:generate-profits')->everyThirtyMinutes();

        // Run new plan system ROI cron job every hour
        // $schedule->command('plans:process-roi')->hourly();

        // Clean up old notifications once a week (keep last 30 days)
        $schedule->command('notifications:cleanup')->weekly();



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
