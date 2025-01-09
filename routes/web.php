<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('customers', CustomerController::class);

Route::resource('customers/{customer}/contacts', ContactController::class)->except(['index']);

Route::get('/customers/{customer}/contacts', [ContactController::class, 'index'])->name('contacts.index');


Route::resource('customers/{customer}/interactions', InteractionController::class)->except(['index']);
Route::get('/customers/{customer}/interactions', [InteractionController::class, 'index'])->name('interactions.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
