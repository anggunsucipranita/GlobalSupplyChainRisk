<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\EconomyController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\RiskController;

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/countries', [CountryController::class, 'index'])->name('countries');

    Route::get('/countries/{code}', [CountryController::class, 'show'])->name('countries.show');

    Route::get('/weather', [WeatherController::class, 'index'])->name('weather');

    Route::get('/currency', [CurrencyController::class, 'index'])->name('currency');

    Route::get('/news', [NewsController::class, 'index'])->name('news');

    Route::get('/ports', [PortController::class, 'index'])->name('ports');

    Route::get('/economy', [EconomyController::class, 'index'])->name('economy');

    Route::get('/comparison', [ComparisonController::class, 'index'])->name('comparison');

    Route::get('/risk', [RiskController::class, 'index'])->name('risk');

});

require __DIR__.'/auth.php';