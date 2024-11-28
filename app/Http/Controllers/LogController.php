<?php
namespace App\Http\Controllers;

use App\Services\LogService;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class LogController extends Controller
{
    protected $logService;
    protected $apiKey;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
        $this->apiKey = env('OPENWEATHER_API_KEY');
    }

    public function index()
    {
        $logs = $this->logService->getRecentLogs();

        return view('dashboard', compact('logs'));
    }


    public function fetch (Request $request)
    {
        try {
            $this->logService->getRecentLogs($request);
            return 'Cache refreshed successfully';
        } catch (\Exception $e) {
            return redirect()->route('tasks')->with('error', $e->getMessage());
        }
    }


    public function refreshCache(Request $request)
    {
        try {
            $city = $request->input('city', 'London');
            $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$this->apiKey}&units=metric";
            $this->logService->fetchAndCacheApiData($apiUrl);
            return redirect()->route('tasks')->with('success', 'Cache refreshed successfully!');
        } catch (\Exception $e) {
            return redirect()->route('tasks')->with('error', $e->getMessage());
        }
    }

    public function clearLogs()
    {
        $this->logService->clearOldLogs();
        return redirect()->route('tasks')->with('success', 'Old logs cleared successfully!');
    }
}
