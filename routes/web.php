<?php

use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\BrandController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::resource('permissions', PermissionController::class);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
Route::resource('roles', RoleController::class)->middleware('auth');
});
Route::resource('users', UserController::class);

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class);

Route::resource('products', ProductController::class);

Route::resource('attributes', ProductAttributeController::class);

});



Route::post('/products/{product}/reviews', [ReviewController::class, 'storeReview'])->name('reviews.store');
Route::post('/reviews/{review}/reply', [ReviewController::class, 'storeReply'])->name('reviews.reply');

Route::delete('/reviews/{review}', [ReviewController::class, 'destroyReview'])->name('reviews.destroy');
Route::delete('/review-replies/{reply}', [ReviewController::class, 'destroyReply'])->name('reviews.replies.destroy');
Route::get('/reviews/replies/{reply}/edit', [ReviewController::class, 'editReply'])->name('reviews.replies.edit');
Route::put('/reviews/replies/{reply}', [ReviewController::class, 'updateReply'])->name('reviews.replies.update');
Route::resource('people', PeopleController::class)->middleware(['auth']);


Route::resource('outlets', OutletController::class)->middleware(['auth']);
Route::resource('brands', BrandController::class)->middleware(['auth']);


require __DIR__.'/auth.php';
