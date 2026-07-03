<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/countries', [CountryController::class, 'index'])->name('countries');

Route::view('/weather', 'weather.index')->name('weather');

Route::view('/currency', 'currency.index')->name('currency');

Route::view('/news', 'news.index')->name('news');

Route::view('/ports', 'ports.index')->name('ports');

Route::view('/comparison', 'comparison.index')->name('comparison');

