<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SubscriptionController;

Route::get('/', [SubscriptionController::class, 'create']);
Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe.store');

Route::get('/verify/{token}', [SubscriptionController::class, 'verify'])->name('verify.email');
