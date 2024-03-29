<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;
use App\Models\Category;
use App\Models\Period;

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

Route::get('/', function(){
    $category = new Category();
    $period = new Period();
    return view('top')->with(['periods' => $period->get(), 'categories' => $category->get()]);
})->name('top');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//投稿
Route::get('/search', [PostController::class, 'index'])->name('index');
Route::get('/search/{post}', [PostController::class, 'show'])->name('show');
Route::get('/posts/create', [PostController::class, 'create'])->name('create')->middleware('auth');
Route::post('/posts', [PostController::class, 'store'])->name('store');
Route::put('/posts/{post}', [PostController::class, 'update'])->name('update');
Route::delete('/posts/{post}', [PostController::class, 'delete'])->name('delete');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('edit');

//コメント
Route::controller(CommentController::class)->middleware(['auth'])->group(function(){
    Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'delete'])->name('comment.delete');
});

//ユーザー
Route::get('/users/{user}', [UserController::class, 'index'])->name('user.index');
Route::get('/users/{user}/favorite', [UserController::class, 'showFavorite'])->name('show.favorite');

//いいねボタン
Route::controller(FavoriteController::class)->middleware(['auth'])->group(function(){
    Route::get('/search/fovorite/{post}', 'favorite')->name('favorite');
    Route::get('/search/unfovorite/{post}', 'unfavorite')->name('unfavorite');
});


require __DIR__.'/auth.php';
