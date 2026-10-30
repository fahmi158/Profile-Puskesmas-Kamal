<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/', [PageController::class, 'profil'])->name('index');
    Route::get('/sejarah', [PageController::class, 'show'])->defaults('slug', 'sejarah')->name('sejarah');
    Route::get('/visi-misi', [PageController::class, 'show'])->defaults('slug', 'visi-misi')->name('visi-misi');
    Route::get('/struktur-organisasi', [PageController::class, 'show'])->defaults('slug', 'struktur-organisasi')->name('struktur-organisasi');
});

Route::get('/layanan', [ServiceController::class, 'index'])->name('services.index');
Route::get('/layanan/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/jadwal', [ScheduleController::class, 'index'])->name('schedules.index');

Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/agenda', [EventController::class, 'index'])->name('events.index');
Route::get('/agenda/{slug}', [EventController::class, 'show'])->name('events.show');

Route::get('/dokumentasi', [AlbumController::class, 'index'])->name('albums.index');
Route::get('/dokumentasi/{slug}', [AlbumController::class, 'show'])->name('albums.show');

Route::get('/video', [VideoController::class, 'index'])->name('videos.index');
Route::get('/video/{slug}', [VideoController::class, 'show'])->name('videos.show');

Route::get('/dokumen', [DocumentController::class, 'index'])->name('documents.index');

Route::get('/faq', [FaqController::class, 'index'])->name('faqs.index');

Route::get('/kontak', [FeedbackController::class, 'create'])->name('contact.index');
Route::post('/kontak', [FeedbackController::class, 'store'])->name('contact.store');

Route::get('/pencarian', [SearchController::class, 'index'])->name('search');

Route::get('/halaman/{slug}', [PageController::class, 'show'])->name('pages.show');