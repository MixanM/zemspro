<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


//Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');

//Route::get('/', function () {
//    return Inertia::render('Dashboard');
//    Route::resource('projects', ProjectController::class);
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('/', ProjectController::class);
    Route::patch('project/{project}', [ProjectController::class, 'update'])->name('project.edit');
    Route::resource('/project', ProjectController::class);
    Route::patch('task/{task}', [TaskController::class, 'update'])->name('task.edit');
    Route::resource('/task', TaskController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
