<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('Index');
})->name('index');


Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('roles', [RoleController::class, 'index'])->name('roles.index');


// Route::resource('products', ProductController::class);
Route::resource('requisitions', RequisitionController::class);
Route::resource('purchase-orders', PurchaseOrderController::class);

Route::patch('requisitions/{requisition}/approve', [RequisitionController::class, 'approve'])->name('requisitions.approve');
Route::patch('purchase-orders/{purchaseOrder}/approve', [PurchaseOrderController::class, 'approve'])->name('purchase-orders.approve');