<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RKBController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseRequestController;

Route::get('/', function () {
    return view('Index');
})->name('index');
Route::get('alert', function () {
    return view('text');
})->name('alert');



Route::get('products', [ProductController::class, 'index'])->name('products.index');



// roles
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




// rkb
Route::resource('rkbs', RKBController::class);

// Tambahkan rute tambahan untuk update, delete item dan create rkb
Route::get('rkbs/items/edit/{id}', [RKBController::class, 'editItem'])->name('rkbs.items.edit');
Route::put('rkbs/items/update/{id}', [RKBController::class, 'updateItem'])->name('rkbs.items.update');
Route::delete('rkbs/items/delete/{id}', [RKBController::class, 'deleteItem'])->name('rkbs.items.delete');
Route::post('rkbs/purchase-request/{id}', [RKBController::class, 'createPurchaseRequest'])->name('rkbs.create.purchase-request');



// PP
Route::resource('PP', PurchaseRequestController::class);
// Tambahkan rute tambahan untuk update, delete item dan create purchase request
Route::get('pp/items/edit/{id}', [PurchaseRequestController::class, 'editItem'])->name('PP.items.edit');
Route::put('pp/items/update/{id}', [PurchaseRequestController::class, 'updateItem'])->name('PP.items.update');
Route::delete('pp/items/delete/{id}', [PurchaseRequestController::class, 'deleteItem'])->name('PP.items.delete');
Route::post('pp/{id}/submit-review', [PurchaseRequestController::class, 'submitForReview'])->name('PP.submitReview');
Route::post('pp/{id}/review', [PurchaseRequestController::class, 'review'])->name('PP.review');
