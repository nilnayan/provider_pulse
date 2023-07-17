<?php

use App\Http\Controllers\AccessLevelsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\DocumentTypesController;
use App\Http\Controllers\EmployeeStatusesController;
use App\Http\Controllers\JobTitlesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SatisfactionLevelsController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserFilesController;
use App\Http\Controllers\UserNotesController;
use App\Http\Controllers\UserStatsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect(route('dashboard'));
});

Route::get('/test/{action?}', function($action = 'index') {
    $controller = new TestController();
    return $controller->$action();
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('access-levels', AccessLevelsController::class);
    Route::resource('departments', DepartmentsController::class);
    Route::resource('document-types', DocumentTypesController::class);
    Route::resource('employee-statuses', EmployeeStatusesController::class);
    Route::resource('job-titles', JobTitlesController::class);
    Route::resource('satisfaction-levels', SatisfactionLevelsController::class);
    Route::resource('users', UsersController::class);
    Route::resource('users.files', UserFilesController::class);
    Route::resource('users.notes', UserNotesController::class);
    Route::resource('users.stats', UserStatsController::class);
});

require __DIR__.'/auth.php';
