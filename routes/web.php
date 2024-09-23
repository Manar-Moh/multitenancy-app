<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Projects;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/projects',Projects::class)->name('projects');
    Route::get('/tenants/change/{id}',TenantController::class)->name('tenants.change');

    Route::controller(UserController::class)->middleware('can:manage-users')->group(function (){
        Route::get('users', 'index')->name('users.index');
        Route::post('users', 'store')->name('users.store');
    });
});
Route::get('invitations/{token}', [\App\Http\Controllers\UserController::class, 'acceptInvitation'])->name('invitations.accept');
require __DIR__.'/auth.php';
