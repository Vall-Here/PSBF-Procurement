<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RKBController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\RushOrderController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseRequestController;


Route::get('/alert', function () {
    return view('text');
})->name('alert');


Route::middleware(['auth:web'])->group(function () {
    Route::get('/', function () {
        return view('Index');
    })->name('index');
});



Route::middleware(['auth:web', 'role:kabag_proc'])->group(function () {
// roles
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/edit/{Role}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{Role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{Role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});



Route::middleware(['auth:web', 'role:kabag_proc'])->group(function () {
    // user 
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});


Route::resource('vendors', VendorController::class);


// rkb
// Route::resource('rkbs', RKBController::class);
Route::middleware(['auth:web', 'role:kabag_proc|kasi_impor|kasi_lokal|kasi_intern|pel_lokal|pel_intern|pel_impor'])->group(function () {
    Route::get('/rkbs', [RKBController::class, 'index'])->name('rkbs.index');
    Route::get('/rkbs/create', [RKBController::class, 'create'])->name('rkbs.create');
    Route::post('/rkbs', [RKBController::class, 'store'])->name('rkbs.store');
    Route::get('/rkbs/edit/{rkb}', [RKBController::class, 'edit'])->name('rkbs.edit');
    Route::put('/rkbs/{rkb}', [RKBController::class, 'update'])->name('rkbs.update');
    Route::delete('/rkbs/{rkb}', [RKBController::class, 'destroy'])->name('rkbs.destroy');

    Route::get('/rkbs/add-item', [RKBController::class, 'addItem'])->name('rkbs.addItem');
    Route::delete('/rkbs/item/{index}', [RKBController::class, 'deleteItemOnAdd'])->name('rkbs.deleteItemOnAdd');
    Route::post('/rkbs/store-item', [RKBController::class, 'storeItem'])->name('rkbs.storeItem');
    Route::get('rkbs/items/edit/{id}', [RKBController::class, 'editItem'])->name('rkbs.items.edit');
    Route::put('rkbs/items/update/{id}', [RKBController::class, 'updateItem'])->name('rkbs.items.update');
    Route::delete('rkbs/items/delete/{id}', [RKBController::class, 'deleteItem'])->name('rkbs.items.delete');
    Route::post('rkbs/purchase-request/{id}', [RKBController::class, 'createPurchaseRequest'])->name('rkbs.create.purchase-request');
});


// PP
Route::middleware(['auth:web', 'role:kabag_proc|kasi_impor|kasi_lokal|kasi_intern|pel_lokal|pel_intern|pel_impor'])->group(function () {
    Route::resource('PP', PurchaseRequestController::class);
    Route::get('pp/items/edit/{id}', [PurchaseRequestController::class, 'editItem'])->name('PP.items.edit');
    Route::put('pp/items/update/{id}', [PurchaseRequestController::class, 'updateItem'])->name('PP.items.update');
    Route::delete('pp/items/delete/{id}', [PurchaseRequestController::class, 'deleteItem'])->name('PP.items.delete');
    Route::post('pp/{id}/submit-review', [PurchaseRequestController::class, 'submitForReview'])->name('PP.submitReview');
});
Route::middleware(['auth:web', 'role:pengendali_gudang|pengendali_proc|pengendali_finansial'])->group(function () {
    Route::resource('PP', PurchaseRequestController::class);
    Route::post('pp/{id}/{role}/review', [PurchaseRequestController::class, 'review'])->name('PP.review');
});


//rush order
Route::middleware(['auth:web', 'role:asset_staff'])->group(function () {
    Route::get('/rush_orders', [RushOrderController::class, 'index'])->name('rush_orders.index');
    Route::get('/rush_orders/create', [RushOrderController::class, 'create'])->name('rush_orders.create');
    Route::post('/rush_orders', [RushOrderController::class, 'store'])->name('rush_orders.store');    
    Route::get('/rush_orders/add-item', [RushOrderController::class, 'addItem'])->name('rush_orders.addItem');
    Route::delete('/rush_orders/item/{index}', [RushOrderController::class, 'deleteItemOnAdd'])->name('rush_orders.deleteItemOnAdd');
    Route::post('/rush_orders/store-item', [RushOrderController::class, 'storeItem'])->name('rush_orders.storeItem');
    Route::post('rush_orders/{id}/submit-review', [RushOrderController::class, 'submitForReview'])->name('rush_orders.submitReview');
});

Route::middleware(['auth:web', 'role:asset_staff|kabag_proc|kasi_impor|kasi_lokal|kasi_intern|pel_lokal|pel_intern|pel_impor'])->group(function () {
    Route::get('/rush_orders', [RushOrderController::class, 'index'])->name('rush_orders.index');
    Route::get('/rush_orders/edit/{rkb}', [RushOrderController::class, 'edit'])->name('rush_orders.edit');
    Route::put('/rush_orders/{rkb}', [RushOrderController::class, 'update'])->name('rush_orders.update');
    Route::delete('/rush_orders/{rkb}', [RushOrderController::class, 'destroy'])->name('rush_orders.destroy');
    Route::get('rush_orders/items/edit/{id}', [RushOrderController::class, 'editItem'])->name('rush_orders.items.edit');
    Route::put('rush_orders/items/update/{id}', [RushOrderController::class, 'updateItem'])->name('rush_orders.items.update');
    Route::delete('rush_orders/items/delete/{id}', [RushOrderController::class, 'deleteItem'])->name('rush_orders.items.delete');
});


Route::middleware(['auth:web', 'role:pengendali_gudang|pengendali_proc|pengendali_finansial'])->group(function () {
    Route::get('/rush_orders', [RushOrderController::class, 'index'])->name('rush_orders.index');
    Route::post('rush_orders/{id}/review', [RushOrderController::class, 'review'])->name('rush_orders.review');
});







// klasifikasi
Route::middleware(['auth:web', 'role:asset_staff|kabag_proc|kasi_impor|kasi_lokal|kasi_intern'])->group(function () {
    Route::get('/klasifikasi', [KlasifikasiController::class, 'index'])->name('klasifikasi.index');
    Route::post('/klasifikasi/update/{id}/{type}', [KlasifikasiController::class, 'update'])->name('klasifikasi.update');
});



// purchase order
Route::resource('purchase_orders', PurchaseOrderController::class);
Route::get('purchase-orders/items', [PurchaseOrderController::class, 'filterItems'])->name('purchase_orders.filter_items');


//auth
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');