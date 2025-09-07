<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfitLossController;
use App\Http\Controllers\TableGeneratorController;

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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login_process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/changePassword', [AuthController::class, 'changePassword'])->name('changePassword');
Route::post('/changePassword', [AuthController::class, 'changePasswordProcess'])->name('changePasswordProcess');
Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['auth']);
Route::resource('roles', RoleController::class)->middleware(['auth']);
Route::resource('users', UserController::class)->middleware(['auth']);
Route::resource('products', ProductController::class)->middleware(['auth']);
Route::resource('invoices', InvoiceController::class)->middleware(['auth']);
Route::resource('tickets', TicketController::class)->middleware(['auth']);
Route::resource('profitlosses', ProfitLossController::class)->middleware(['auth']);
Route::get('table_generator', [TableGeneratorController::class, 'index'])->name('table_generator.index')->middleware(['auth']);
Route::post('table_generator', [TableGeneratorController::class, 'run'])->name('table_generator.run')->middleware(['auth']);
