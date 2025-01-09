<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\Api\ShortUrlApiController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('auth')->group(function () {
    Route::get('superadmin/invite', [SuperAdminController::class, 'showInviteForm'])->name('superadmin.invite');
    Route::post('superadmin/invite', [SuperAdminController::class, 'sendInvite']);
    Route::get('superadmin/invites', [SuperAdminController::class, 'viewInvites']);
    Route::get('bulk-url/upload', [BulkUrlController::class, 'showBulkForm']);
    Route::post('bulk-url/upload', [BulkUrlController::class, 'processBulkUpload']);
    Route::get('bulk-url/download', [BulkUrlController::class, 'downloadCsv']);
    Route::post('short-url', [ShortUrlController::class, 'generateShortUrl']);
    Route::get('short-urls', [ShortUrlController::class, 'viewShortUrls']);
    Route::get('/user/dashboard', [UserController::class, 'listUrls']);
    Route::post('/user/generate', [UserController::class, 'generateShortUrl']);
    Route::get('/user/delete/{id}', [ShortUrlController::class, 'delete']);
});
Route::get('signup/{token}', [SignupController::class, 'showSignupForm'])->name('signup');
Route::post('signup', [SignupController::class, 'processSignup']);

Route::get('{shortUrl}', [RedirectController::class, 'redirect'])->name('shortUrl.redirect');
Route::post('generate-short-url', [ShortUrlApiController::class, 'generateShortUrl']);
Route::delete('delete-short-url', [ShortUrlApiController::class, 'deleteShortUrl']);

Route::middleware(['auth', 'checkAdmin'])->group(function () {
    Route::get('/admin/dashboard', [SuperAdminController::class, 'index']);
    Route::post('/admin/invite', [AdminController::class, 'invite']);
});
