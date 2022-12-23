<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BookController;
use App\Http\Controllers\Backend\AuthorController;
use App\Http\Controllers\Backend\CategoriController;

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


// books
Route::get("/books/all", [BookController::class, 'all']);
Route::get("/books/{id}", [BookController::class, 'getShow']);
Route::get("/books", [BookController::class, 'index']);
Route::get("/book/{id}", [BookController::class, 'show']);

Route::post("/book", [BookController::class, 'store']);
Route::post("/book/{id}", [BookController::class, 'update']);
Route::post("/book/{id}", [BookController::class, 'destroy']);

// author
Route::get("/authors", [AuthorController::class, 'index']);
Route::get("/author/{id}", [AuthorController::class, 'show']);

Route::post("/author", [AuthorController::class, 'store']);
Route::post("/author/{id}", [AuthorController::class, 'update']);
Route::delete("/author/{id}", [AuthorController::class, 'destroy']);

// categori
Route::get("/categories", [CategoriController::class, 'index']);
Route::get("/categori/{id}", [CategoriController::class, 'show']);

Route::post("/categori", [CategoriController::class, 'store']);
Route::post("/categori/{id}", [CategoriController::class, 'update']);
Route::delete("/categori/{id}", [CategoriController::class, 'destroy']);

