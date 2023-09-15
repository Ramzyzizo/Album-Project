<?php

use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

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
    return view('auth.register');
})->middleware('guest');

Auth::routes();

//auth route
Route::group(['middleware'=>'auth'],function (){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/album',AlbumController::class);
    Route::post('/album_delete',[AlbumController::class,'delete'])->name('album.delete');
    Route::post('/album_move',[AlbumController::class,'move'])->name('album.move');
    //check photos for album to show move option or not
    Route::get('/album_check/{id}',[AlbumController::class,'album_check'])->name('album_check');

});
