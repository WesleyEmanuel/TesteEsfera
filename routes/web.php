<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(auth()->check()) {
        return redirect('/tasks');
    }
    
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return redirect('/tasks');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/register-user', [RegisteredUserController::class, 'create'])->name('user.register');

    Route::get('/profile/{user}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::resource('users', UserController::class);
    Route::resource('tasks', TaskController::class)->except(['index']);
    Route::put('user-tasks/{taskId}', [TaskController::class, 'userTask'])->name('tasks.user');
    Route::put('user-tasks-unlink/{task}/{user}', [TaskController::class, 'unlinkUserTask'])->name('tasks.user.unlink');
});

require __DIR__.'/auth.php';
