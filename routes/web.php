<?php

use App\Http\Controllers\{ContactController,
    HomeController,
    ProductController,
    ProductTypeController,
    RentController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('home');
});
Route::get('/home', HomeController::class)->name('home');

Route::get('/types/create', [ProductTypeController::class, 'create'])->name('types.create');
Route::post('/types', [ProductTypeController::class, 'store'])->name('types.store');
Route::get('/types', [ProductTypeController::class, 'index'])->name('types.index');
Route::get('/types/{productType}', [ProductTypeController::class, 'show'])->name('types.show');
Route::get('/types/{productType}/edit', [ProductTypeController::class, 'edit'])->name('types.edit');
Route::put('/types/{productType}', [ProductTypeController::class, 'update'])->name('types.update');
Route::delete('/types/{productType}', [ProductTypeController::class, 'destroy'])->name('types.destroy');

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
Route::post('/contacts/details', [ContactController::class, 'details'])->name('contacts.details');

Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}/edit', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('/rents/create', [RentController::class, 'create'])->name('rents.create');
Route::post('/rents', [RentController::class, 'store'])->name('rents.store');
Route::get('/rents', [RentController::class, 'index'])->name('rents.index');
Route::get('/rents/{rent}', [RentController::class, 'show'])->name('rents.show');
Route::get('/rents/{rent}/edit', [RentController::class, 'edit'])->name('rents.edit');
Route::put('/rents/{rent}', [RentController::class, 'update'])->name('rents.update');
Route::delete('/rents/{rent}', [RentController::class, 'destroy'])->name('rents.destroy');
Route::post('/rents/{rent}/close', [RentController::class, 'close'])->name('rents.close');
Route::post('/rents/{rent}/change-status', [RentController::class, 'changeStatus'])->name('rents.change-status');
Route::get('/rents/{rent}/renew', [RentController::class, 'renewPage'])->name('rents.renew.page');
Route::post('/rents/{rent}/renew', [RentController::class, 'renew'])->name('rents.renew');
Route::get('/rents/{rent}/contract', [RentController::class, 'contract'])->name('pdf.contract');
