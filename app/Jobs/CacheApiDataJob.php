<?php
namespace App\Jobs;

use App\Services\LogService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class CacheApiDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $apiUrl;

    /**
     * Create a new job instance.
     *
     * @param string $apiUrl
     */
    public function __construct(string $apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(LogService $logService)
    {
        try {
            \Log::info("started fetching");
            $logService->fetchAndCacheApiData($this->apiUrl);
        } catch (\Exception $e) {
            \Log::error("Failed to cache API data: {$e->getMessage()}");
        }
    }
}
