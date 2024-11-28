<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Repositories\LogRepository;
use GuzzleHttp\Client;

class LogService
{
    protected $logRepository;
    protected $client;

    public function __construct(LogRepository $logRepository,Client $client)
    {
        $this->logRepository = $logRepository;
        $this->client = $client;
    }

    public function fetchAndCacheApiData($apiUrl)
    {
        $response = $this->client->get($apiUrl);
        $data = json_decode($response->getBody(), true);
        $this->logRepository->createLog($apiUrl, $data);
        Cache::put('api_data', $data, now()->addHour());
        return 'success';

    }

    public function getRecentLogs($limit = 10)
    {
        return $this->logRepository->getRecentLogs($limit);
    }

    public function clearOldLogs($days = 30)
    {
        return $this->logRepository->deleteOldLogs($days);
    }

}
