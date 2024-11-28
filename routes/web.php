<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LogController::class, 'index'])->name('tasks'); // Default page
Route::get('/fetch', [LogController::class, 'fetch'])->name('fetch');
Route::post('/refresh-cache', [LogController::class, 'refreshCache']);
Route::post('/clear-logs', [LogController::class, 'clearLogs'])->name('clear-logs');
