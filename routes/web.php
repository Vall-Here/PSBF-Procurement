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
Route::get('alert', function () {
    return view('text');
})->name('alert');



Route::get('products', [ProductController::class, 'index'])->name('products.index');


Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
Route::get('roles/edit/{Role}', [RoleController::class, 'edit'])->name('roles.edit');
Route::put('roles/{Role}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('roles/{Role}', [RoleController::class, 'destroy'])->name('roles.destroy');



// user 
Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::post('users', [UserController::class, 'store'])->name('users.store');
Route::get('users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Route::resource('products', ProductController::class);
Route::resource('requisitions', RequisitionController::class);
Route::resource('purchase-orders', PurchaseOrderController::class);

Route::patch('requisitions/{requisition}/approve', [RequisitionController::class, 'approve'])->name('requisitions.approve');
Route::patch('purchase-orders/{purchaseOrder}/approve', [PurchaseOrderController::class, 'approve'])->name('purchase-orders.approve');