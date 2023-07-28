<?php

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    $articles = Article::latest()->paginate(12);
    return view('welcome', ["articles" => $articles]);
});

Route::get("/blog/{article:id}", [DashboardController::class, 'show']);

Route::get('/home', [DashboardController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('/home', DashboardController::class);
});

Auth::routes();

