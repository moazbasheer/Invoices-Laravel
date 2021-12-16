<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
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
Auth::routes();
Auth::routes(['register' => false]);
Route::group(['middleware' => ['guest']], function() {
    Route::view('/', 'auth.login');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/section/{id}', [InvoiceController::class, 'getProducts']);
    Route::get('/print_invoice/{id}', [InvoiceController::class, 'print'])->name('invoice.print');
    Route::get('/export_invoices', [InvoiceController::class, 'export'])->name('invoices.export');
    Route::get('/invoices_report', [InvoicesReport::class, 'index']);
    Route::get('/mark_as_read', [InvoiceController::class, 'markAllAsRead'])->name('markAllAsRead');
    Route::post('/invoices_report', [InvoicesReport::class, 'search_invoices']);

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('invoices_archived', invoicesArchiveController::class);
    Route::resource('products', ProductController::class);

    Route::get('/{page}', [AdminController::class,'index']);
});
