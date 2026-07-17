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
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\DataVisualizationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\PortManagementController;
use App\Http\Controllers\Admin\ArticleManagementController;

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

    Route::get('/watchlists', [WatchlistController::class, 'index'])
    ->name('watchlists.index');

    Route::post('/watchlists', [WatchlistController::class, 'store'])
    ->name('watchlists.store');

    Route::delete('/watchlists/{id}', [WatchlistController::class, 'destroy'])
    ->name('watchlists.destroy');

    Route::get('/visualization',[DataVisualizationController::class,'index'])
    ->name('visualization');

    Route::get('/admin', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');

    Route::get(
    '/admin/users',
    [UserManagementController::class,'index']
    )->name('admin.users');

    Route::delete(
    '/admin/users/{user}',
    [UserManagementController::class, 'destroy']
)->name('admin.users.destroy');

Route::get(
    '/admin/users/{user}/edit',
    [UserManagementController::class, 'edit']
)->name('admin.users.edit');

Route::put(
    '/admin/users/{user}',
    [UserManagementController::class, 'update']
)->name('admin.users.update');

Route::get(
    '/admin/users/create',
    [UserManagementController::class, 'create']
)->name('admin.users.create');

Route::post(
    '/admin/users',
    [UserManagementController::class, 'store']
)->name('admin.users.store');

Route::get(
    '/admin/users/{user}',
    [UserManagementController::class, 'show']
)->name('admin.users.show');

Route::get('/admin/ports', [PortManagementController::class,'index'])->name('admin.ports');

Route::get('/admin/ports/create', [PortManagementController::class,'create'])->name('admin.ports.create');

Route::post('/admin/ports', [PortManagementController::class,'store'])->name('admin.ports.store');

Route::get('/admin/ports/{port}/edit', [PortManagementController::class,'edit'])->name('admin.ports.edit');

Route::put('/admin/ports/{port}', [PortManagementController::class,'update'])->name('admin.ports.update');

Route::delete('/admin/ports/{port}', [PortManagementController::class,'destroy'])->name('admin.ports.destroy');

Route::get('/admin/articles', [ArticleManagementController::class,'index'])->name('admin.articles');

Route::get('/admin/articles/create', [ArticleManagementController::class,'create'])->name('admin.articles.create');

Route::post('/admin/articles', [ArticleManagementController::class,'store'])->name('admin.articles.store');

Route::get('/admin/articles/{article}', [ArticleManagementController::class,'show'])->name('admin.articles.show');

Route::get('/admin/articles/{article}/edit', [ArticleManagementController::class,'edit'])->name('admin.articles.edit');

Route::put('/admin/articles/{article}', [ArticleManagementController::class,'update'])->name('admin.articles.update');

Route::delete('/admin/articles/{article}', [ArticleManagementController::class,'destroy'])->name('admin.articles.destroy');

});

require __DIR__.'/auth.php';