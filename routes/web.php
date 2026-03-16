<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimelogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('clients', ClientController::class);
    Route::resource('/projects',ProjectController::class);
    Route::post('/projects/{project}/archive', [ProjectController::class, 'archive'])->name('projects.archive');
    Route::post('/projects/{project}/members', [ProjectController::class, 'assignMembers'])->name('projects.members');
    Route::resource('/tasks', TaskController::class)->except(['index']);
    Route::resource('/timelogs', TimelogController::class)->except(['index', 'show']);
    Route::resource('users', UserController::class)->except(['show']);
});

require __DIR__.'/auth.php';
