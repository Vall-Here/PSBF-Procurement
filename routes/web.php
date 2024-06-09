<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\PurchaseOrderController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('products', ProductController::class);
Route::resource('requisitions', RequisitionController::class);
Route::resource('purchase-orders', PurchaseOrderController::class);

Route::patch('requisitions/{requisition}/approve', [RequisitionController::class, 'approve'])->name('requisitions.approve');
Route::patch('purchase-orders/{purchaseOrder}/approve', [PurchaseOrderController::class, 'approve'])->name('purchase-orders.approve');