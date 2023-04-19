<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController; 
use App\Http\Controllersi\ConvertedimageController; 
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


Route::get('/', [ImageController::class,'index'])->name('image.index');

Route::get('/grid', 'ConvertedimageController@index');
Route::get('/stats', 'ImageController@stats');

Route::get('/image', [ImageController::class,'index'])->name('image.index');
Route::post('/image', [ImageController::class,'store'])->name('image.store');
Route::post('/image/change', [ImageController::class,'change'])->name('image.change');
Route::get('/image/{imageId?}', 'ImageController@showimage');
    


