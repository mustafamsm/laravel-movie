<?php

use Inertia\Inertia;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CastController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\MovieAttachController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\TvShowController;
use App\Http\Controllers\Admin\EpisodeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Frontend\WelcomeController;
use App\Http\Controllers\Frontend\FrontendTagController;
use App\Http\Controllers\Frontend\FrontendCastController;
use App\Http\Controllers\Frontend\FrontendGenreController;
use App\Http\Controllers\Frontend\FrontendMovieController;
use App\Http\Controllers\Frontend\FrontendTvShowController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/movies', [FrontendMovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie:slug}', [FrontendMovieController::class, 'show'])->name('movies.show');
Route::get('/tv-shows', [FrontendTvShowController::class, 'index'])->name('tvShows.index');
Route::get('/tv-shows/{tv_show:slug}', [FrontendTvShowController::class, 'show'])->name('tvShows.show');
Route::get('/tv-shows/{tv_show:slug}/seasons/{season:slug}', [FrontendTvShowController::class, 'seasonShow'])->name('season.show');
Route::get('/episodes/{episode:slug}', [FrontendTvShowController::class, 'showEpisode'])->name('episodes.show');
Route::get('/casts', [FrontendCastController::class, 'index'])->name('casts.index');
Route::get('/casts/{cast:slug}', [FrontendCastController::class, 'show'])->name('casts.show');
Route::get('/genres/{genre:slug}', [FrontendGenreController::class, 'show'])->name('genres.show');
Route::get('/tags/{tag:slug}', [FrontendTagController::class, 'show'])->name('tags.show');




Route::middleware(['auth:sanctum', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Admin/Index');
    })->name('index');
    Route::resource('/movies', MovieController::class);
    Route::get(
        '/movies/{movie}/attach',
        [MovieAttachController::class, 'index']
    )->name('movies.attach');
    Route::post('/movies/{movie}/add-trailer', [MovieAttachController::class, 'addTrailer'])->name(
        'movies.add.trailer'
    );
    Route::post('/movies/{movie}/add-download', [MovieAttachController::class, 'addDownload'])->name(
        'movies.add.download'
    );
    Route::post('/movies/{movie}/add-casts', [MovieAttachController::class, 'addCast'])->name(
        'movies.add.casts'
    );
    Route::post('/movies/{movie}/add-tags', [MovieAttachController::class, 'addTag'])->name(
        'movies.add.tags'
    );
    Route::delete('/trailer-urls/{trailer_url}', [MovieAttachController::class, 'destroyTrailer'])->name('trailers.destroy');
    Route::delete('/downloads/{download}', [MovieAttachController::class, 'destroyDownload'])->name('downloads.destroy');
    Route::resource('/tv-shows', TvShowController::class);
    Route::resource('/tv-shows/{tv_show}/seasons', SeasonController::class);
    Route::resource('/tv-shows/{tv_show}/seasons/{season}/episodes', EpisodeController::class);
    Route::resource('/genres', GenreController::class);
    Route::resource('/casts', CastController::class);
    Route::resource('/tags', TagController::class);


    Route::resource('permissions',PermissionController::class);
     // Roles
     Route::resource('roles', RoleController::class);

     // Users
     Route::resource('users', UserController::class);
 
});
 




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
    //    auth()->user()->assignRole('admin');
        return Inertia::render('Dashboard');
    })->name('dashboard');

});
