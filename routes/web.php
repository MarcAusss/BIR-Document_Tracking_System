<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DocumentController;
use App\Models\Document;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminProfileController;
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
    return view('auth.login');
});

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Admin Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin', // Custom middleware to check admin role
])->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');

    // Admin: View all users
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');

    // Admin: Edit Profile
    Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::post('/admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');

    // Admin: Edit User
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    });
});

// User Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:user', // Custom middleware to check user role
])->group(function () {
    Route::get('/user/dashboard', [AuthController::class, 'userDashboard'])->name('user.dashboard');
});

// Redirect to appropriate dashboard
Route::get('/dashboard', [AuthController::class, 'redirectToDashboard'])->middleware(['auth', 'verified']);

// Document Routes
Route::resource('documents', DocumentController::class);
Route::post('/documents/{id}/update-status', [DocumentController::class, 'updateStatus'])->name('documents.updateStatus');
Route::post('/documents/send', [DocumentController::class, 'send'])->name('documents.send');
Route::get('/user/documents', [DocumentController::class, 'indexOffice'])->name('documents.indexOffice');

// User: Edit profile
Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::post('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
});

Route::post('/notifications/{id}/mark-as-read', function ($id) {
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();

    return redirect()->back();
})->name('notifications.markAsRead');

Route::get('/notifications/unread', function () {
    return response()->json(auth()->user()->unreadNotifications);
})->name('notifications.unread');