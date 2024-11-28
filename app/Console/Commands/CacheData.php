<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CacheData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cache-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting data cleaning and caching process...');

        // Example: Cleaning old data from a table
        \DB::table('logs')->where('created_at', '<', now()->subDays(30))->delete();
        $this->info('Old logs have been deleted.');

        // Fetch data from the API
        $apiData = $this->fetchApiData();

        // Cache the API data
        Cache::put('api_data', $apiData, now()->addHours(6));
        $this->info('API data has been cached.');

        $this->info('Process completed.');
    }

    protected function fetchApiData()
    {
        $url = 'https://api.example.com/data';

        try {
            $response = \Http::get($url);
            if ($response->successful()) {
                return $response->json();
            } else {
                $this->error('Failed to fetch API data.');
                return null;
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return null;
        }
    }
}
