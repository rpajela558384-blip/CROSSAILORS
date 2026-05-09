<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfficerPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Officer\DashboardController as OfficerDashboardController;
use App\Http\Controllers\Officer\CarouselController;
use App\Http\Controllers\Officer\AnnouncementController;
use App\Http\Controllers\Officer\OfficerProfileController;
use App\Http\Controllers\Officer\TicketManageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Public (guests only — admins are redirected away)
Route::middleware(['no-admin'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/officers', [OfficerPageController::class, 'index'])->name('officers.index');
});

// Authenticated students & officers (admins redirected away)
Route::middleware(['auth', 'verified', 'no-admin'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tickets
    Route::resource('tickets', TicketController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('/tickets/{ticket}/replies', [TicketController::class, 'reply'])->name('tickets.reply');

    // Notifications JSON endpoint for bell dropdown
    Route::get('/api/notifications', [NotificationController::class, 'apiIndex'])->name('notifications.api');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::get('/notifications/{id}/visit', [NotificationController::class, 'visit'])->name('notifications.visit');
    Route::post('/push-subscriptions', [NotificationController::class, 'subscribe'])->name('push.subscribe');
});

// Officer routes (officers only — admins use their own panel)
Route::middleware(['auth', 'verified', 'role:officer'])->prefix('officer')->name('officer.')->group(function () {
    Route::get('/dashboard', [OfficerDashboardController::class, 'index'])->name('dashboard');

    Route::get('/api/notifications', [NotificationController::class, 'apiIndex'])->name('notifications.api');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::get('/notifications/{id}/visit', [NotificationController::class, 'visit'])->name('notifications.visit');

    Route::resource('carousel', CarouselController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::patch('/carousel/{carousel}/toggle', [CarouselController::class, 'toggle'])->name('carousel.toggle');

    Route::resource('announcements', AnnouncementController::class)->except(['show']);
    Route::patch('/announcements/{announcement}/toggle', [AnnouncementController::class, 'toggle'])->name('announcements.toggle');

    Route::resource('officers', OfficerProfileController::class)->except(['show']);
    Route::get('/officers/board/search', [OfficerProfileController::class, 'search'])->name('officers.search');

    Route::get('/tickets', [TicketManageController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketManageController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/reply', [TicketManageController::class, 'reply'])->name('tickets.reply');
    Route::patch('/tickets/{ticket}/status', [TicketManageController::class, 'updateStatus'])->name('tickets.status');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/api/notifications', [NotificationController::class, 'apiIndex'])->name('notifications.api');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::get('/notifications/{id}/visit', [NotificationController::class, 'visit'])->name('notifications.visit');

    Route::resource('users', UserController::class)->except(['show']);
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.role');
    Route::patch('/users/{user}/toggle', [UserController::class, 'toggleActive'])->name('users.toggle');
});

require __DIR__.'/auth.php';
