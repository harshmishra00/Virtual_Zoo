<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin;

// ─── Public Routes ──────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/animals', [\App\Http\Controllers\ExplorerController::class, 'animals'])->name('animals.index');
Route::get('/flowers', [\App\Http\Controllers\ExplorerController::class, 'flowers'])->name('flowers.index');
Route::get('/animals/{slug}', [\App\Http\Controllers\ExplorerController::class, 'showAnimal'])->name('animals.show');
Route::get('/flowers/{slug}', [\App\Http\Controllers\ExplorerController::class, 'showFlower'])->name('flowers.show');
Route::get('/aquarium', [\App\Http\Controllers\ExplorerController::class, 'aquarium'])->name('aquarium');
Route::get('/fishes/{slug}', [\App\Http\Controllers\ExplorerController::class, 'showFish'])->name('fishes.show');
Route::get('/video/aquarium', function() {
    $path = storage_path('app/data/Dream Aquarium - 2 Hours - 8 Tanks (4K) [HHi8qOtHnhE].mkv');
    if (!file_exists($path)) abort(404);
    return response()->file($path);
})->name('video.aquarium');
Route::get('/tour', [\App\Http\Controllers\ExplorerController::class, 'tour'])->name('tour');
Route::get('/tour/more', [\App\Http\Controllers\ExplorerController::class, 'tourMore'])->name('tour.more');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/adopt', [AdoptionController::class, 'index'])->name('adopt.index');
Route::post('/adopt/confirm', [AdoptionController::class, 'confirm'])->name('adopt.confirm');
Route::get('/adopt/{adoption}/payment', [AdoptionController::class, 'payment'])->name('adopt.payment');
Route::post('/adopt/{adoption}/payment', [AdoptionController::class, 'processPayment'])->name('adopt.process-payment');
Route::get('/adopt/{adoption}/certificate', [AdoptionController::class, 'downloadCertificate'])->name('adopt.certificate');

// ─── Sitemap ─────────────────────────────────────────────────────────────────
Route::get('/sitemap.xml', function () {
    $animals  = App\Models\Animal::all();
    $habitats = App\Models\Habitat::all();
    return response()->view('sitemap', compact('animals', 'habitats'))
        ->header('Content-Type', 'text/xml');
})->name('sitemap');

// ─── Auth Required Routes ────────────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// ─── Admin Routes ────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Animals
    Route::get('/animals', [Admin\AnimalController::class, 'index'])->name('animals.index');
    Route::get('/animals/create', [Admin\AnimalController::class, 'create'])->name('animals.create');
    Route::post('/animals', [Admin\AnimalController::class, 'store'])->name('animals.store');
    Route::get('/animals/{animal}/edit', [Admin\AnimalController::class, 'edit'])->name('animals.edit');
    Route::put('/animals/{animal}', [Admin\AnimalController::class, 'update'])->name('animals.update');
    Route::delete('/animals/{animal}', [Admin\AnimalController::class, 'destroy'])->name('animals.destroy');
    Route::post('/animals/{id}/restore', [Admin\AnimalController::class, 'restore'])->name('animals.restore');

    // Reviews
    Route::get('/reviews', [Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve', [Admin\ReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('/reviews/{review}', [Admin\ReviewController::class, 'reject'])->name('reviews.reject');

    // Users
    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/role', [Admin\UserController::class, 'assignRole'])->name('users.role');

    // Activity Logs
    Route::get('/activity-logs', [Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
});

require __DIR__ . '/auth.php';
