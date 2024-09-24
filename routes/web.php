<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Projects;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('invitations/{token}', [\App\Http\Controllers\UserController::class, 'acceptInvitation'])->name('invitations.accept');

require __DIR__.'/auth.php';
