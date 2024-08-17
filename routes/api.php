<?php

use App\Http\Controllers\Api\AboutUsApiController;
use App\Http\Controllers\Api\CardsApiController;
use App\Http\Controllers\Api\ClientsApiController;
use App\Http\Controllers\Api\CommunicateApiController;
use App\Http\Controllers\Api\ContactUsApiController;
use App\Http\Controllers\Api\OurSolutionApiController;
use App\Http\Controllers\Api\ServicesApiController;
use App\Http\Controllers\Api\SliderApiController;
use App\Http\Controllers\Api\ArticalApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/services', [ServicesApiController::class,'index']);
Route::get('/certificates', [OurSolutionApiController::class,'index']);
Route::get('/agents', [ClientsApiController::class,'index']);
Route::get('/aboutUs', [AboutUsApiController::class,'index']);
Route::get('/artical', [ArticalApiController::class,'index']);
Route::get('/cards', [CardsApiController::class,'index']);
Route::get('/contactUs', [ContactUsApiController::class,'index']);
Route::get('/homePage', [SliderApiController::class,'index']);
Route::get('/sendMessage', [CommunicateApiController::class,'sendMessage']);



Route::get('/test1/create', [App\Http\Controllers\Test1Controller::class, 'create'])->name('test1.create.api');
Route::get('/test1/edit', [App\Http\Controllers\Test1Controller::class, 'edit'])->name('test1.edit.api');
Route::get('/test1/index', [App\Http\Controllers\Test1Controller::class, 'index'])->name('test1.index.api');
Route::get('/test1/store', [App\Http\Controllers\Test1Controller::class, 'store'])->name('test1.store.api');
Route::get('/test1/update', [App\Http\Controllers\Test1Controller::class, 'update'])->name('test1.update.api');
Route::get('/test2/create', [App\Http\Controllers\Test2Controller::class, 'create'])->name('test2.create.api');
Route::get('/test2/edit', [App\Http\Controllers\Test2Controller::class, 'edit'])->name('test2.edit.api');
Route::get('/test2/index', [App\Http\Controllers\Test2Controller::class, 'index'])->name('test2.index.api');
Route::get('/test2/store', [App\Http\Controllers\Test2Controller::class, 'store'])->name('test2.store.api');
Route::get('/test2/update', [App\Http\Controllers\Test2Controller::class, 'update'])->name('test2.update.api');
Route::get('/test3/create', [App\Http\Controllers\Api\Test3Controller::class, 'create'])->name('test3.create.api');
Route::get('/test3/edit', [App\Http\Controllers\Api\Test3Controller::class, 'edit'])->name('test3.edit.api');
Route::get('/test3/index', [App\Http\Controllers\Api\Test3Controller::class, 'index'])->name('test3.index.api');
Route::get('/test3/store', [App\Http\Controllers\Api\Test3Controller::class, 'store'])->name('test3.store.api');
Route::get('/test3/update', [App\Http\Controllers\Api\Test3Controller::class, 'update'])->name('test3.update.api');
Route::get('/test4/create', [App\Http\Controllers\Api\Test4Controller::class, 'create'])->name('test4.create.api');
Route::get('/test4/edit', [App\Http\Controllers\Api\Test4Controller::class, 'edit'])->name('test4.edit.api');
Route::get('/test4/index', [App\Http\Controllers\Api\Test4Controller::class, 'index'])->name('test4.index.api');
Route::get('/test4/store', [App\Http\Controllers\Api\Test4Controller::class, 'store'])->name('test4.store.api');
Route::get('/test4/update', [App\Http\Controllers\Api\Test4Controller::class, 'update'])->name('test4.update.api');
Route::get('/imagepro/index', [App\Http\Controllers\Api\ImageproController::class, 'index'])->name('imagepro.index.api');
Route::get('/imagetest/index', [App\Http\Controllers\Api\ImagetestController::class, 'index'])->name('imagetest.index.api');
Route::get('/imagetest1/index', [App\Http\Controllers\Api\Imagetest1Controller::class, 'index'])->name('imagetest1.index.api');
Route::get('/imagetest2/index', [App\Http\Controllers\Api\Imagetest2Controller::class, 'index'])->name('imagetest2.index.api');
Route::get('/imagetest3/index', [App\Http\Controllers\Api\Imagetest3Controller::class, 'index'])->name('imagetest3.index.api');