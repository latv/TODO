<?php
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('/tasks', TaskController::class)->only(['index', 'create', 'destroy']);
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggleStatus'])->name('tasks.toggle');
