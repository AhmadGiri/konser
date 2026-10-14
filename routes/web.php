<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OrderController::class, 'index'])->name('customer.index');
Route::post('/checkout', [OrderController::class, 'store'])->name('customer.checkout');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');
    });
    
    Route::get('/admin/dashboard', [OrderController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::resource('admin/events', EventController::class);
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');


require __DIR__.'/auth.php';