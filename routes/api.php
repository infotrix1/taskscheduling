<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/api-data1', function () {
    $data = Cache::get('api_data', 'No data found. Cache is empty or expired.');
    return response()->json($data);
});

Route::get('/api-data', function () {
    return response()->json(Cache::get('api_data', 'No cached data found.'));
});

// Fetch logs
Route::get('/logs', function () {
    return response()->json(\DB::table('logs')->orderBy('requested_at', 'desc')->limit(10)->get());
});

// Refresh cache
Route::post('/refresh-cache', function () {
    Artisan::call('api:cache');
    return response()->json(['message' => 'Cache refreshed successfully!']);
});

// Clear old logs
Route::post('/clear-logs', function () {
    Artisan::call('logs:clean');
    return response()->json(['message' => 'Old logs cleared successfully!']);
});
