<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Pages\ArticleController;
use App\Http\Controllers\Pages\ProgramController;
use App\Http\Controllers\Pages\MemberController;
use App\Http\Controllers\Pages\MagazineController;

/*
|--------------------------------------------------------------------------
| Public Routes (Guest / Pembaca)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/tentang', 'pages.tentang')->name('tentang');

Route::get('/program', [ProgramController::class, 'index'])->name('program');

Route::get('/organisasi', [MemberController::class, 'index'])->name('organisasi');

Route::get('/artikel', [ArticleController::class, 'index'])
    ->name('artikel.index');

Route::get('/artikel/{slug}', [ArticleController::class, 'show'])
    ->name('artikel.show');

Route::get('/majalah', [MagazineController::class, 'index'])
    ->name('majalah.index');

Route::get('/majalah/{magazine}', [MagazineController::class, 'show'])
    ->name('majalah.show');

Route::get('/majalah-preview/{magazine}', [MagazineController::class, 'preview'])
    ->name('majalah.preview');
