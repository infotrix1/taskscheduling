<?php
namespace App\Repositories;

use App\Models\Log;
use Carbon\Carbon;

class LogRepository
{
    public function getRecentLogs($limit = 10)
    {
        return Log::orderBy('requested_at', 'desc')->limit($limit)->get();
    }

    public function deleteOldLogs($days = 30)
    {
        $cutoffDate = Carbon::now()->subDays($days);
        return Log::where('requested_at', '<', $cutoffDate)->delete();
    }

    // Create a new log entry
    public function createLog($endpoint, $response)
    {
        return Log::create([
            'endpoint' => $endpoint,
            'response' => json_encode($response),
            'requested_at' => Carbon::now(),
        ]);
    }
}
