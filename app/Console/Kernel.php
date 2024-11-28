<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\CacheApiDataJob;
use App\Jobs\DeleteLogDataJob;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $apiKey = env('OPENWEATHER_API_KEY'); // Get the API key here
        $url = "https://api.openweathermap.org/data/2.5/weather?q=Abuja&appid={$apiKey}&units=metric";

        $schedule->job(new CacheApiDataJob($url))->hourly();
        $schedule->job(new DeleteLogDataJob())->daily();
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
