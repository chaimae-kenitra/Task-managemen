<?php

use Illuminate\Support\Facades\Route;
use PHPUnit\Event\Code\Test;

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
Route::get('/', function () { return view('login'); });

Auth::routes();
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('tasks.index');
Route::get('employees/{id}', [App\Http\Controllers\AdminController::class, 'getEmployees'])->name('employees.getEmployees');
Route::delete('/tasks/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('tasks.destroy');
Route::post('/admin', [App\Http\Controllers\AdminController::class, 'store'])->name('tasks.store');

Route::get('getHistory',[App\Http\Controllers\AdminController::class,'getHistory']);



