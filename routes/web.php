<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\invoicesArchiveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\InvoicesReport;
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

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();
Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('invoices', InvoiceController::class);
Route::resource('sections', SectionController::class);
Route::resource('products', ProductController::class)->middleware('auth');
Route::get('/section/{id}', [InvoiceController::class, 'getProducts']);
Route::resource('invoices_archived', invoicesArchiveController::class);
Route::get('/print_invoice/{id}', [InvoiceController::class, 'print']);
Route::get('/export_invoices', [InvoiceController::class, 'export'])->name('invoices.export');
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});
Route::get('/invoices_report', [InvoicesReport::class, 'index']);
Route::post('/invoices_report', [InvoicesReport::class, 'search_invoices']);
Route::get('/{page}', [AdminController::class,'index']);
