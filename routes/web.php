<?php

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
    return view('welcome');
});
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('tasks.index');
Route::delete('/tasks/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('tasks.destroy');
Route::post('/admin', [App\Http\Controllers\AdminController::class, 'store'])->name('tasks.store');