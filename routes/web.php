<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\NavController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\SocialsController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\TrashController;
use App\Helpers\SoftDeletedHelper;

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

Route::middleware('auth')->prefix('admin')->group(function () {
    foreach (SoftDeletedHelper::getSoftDeletedControllers() as $controller) {
        Route::middleware('can:edit ' . strtolower($controller->modelName))->group(function () use ($controller) {
            Route::post($controller->name . '/{id}/restore', [$controller->class::class, 'restore'])->name(strtolower($controller->modelName) . '.restore');
            Route::delete($controller->name . '/{id}/force', [$controller->class::class, 'destroyPermanently'])->name(strtolower($controller->modelName) . '.destroyPerm');
        });
    }

    Route::get('/', [UserController::class, 'resolveHome'])->name('admin.index');

    Route::resource('/page', PageController::class)->except(['show'])->middleware('can:edit page');

    Route::resource('/album', AlbumController::class)->except(['show'])->middleware('can:edit album');

    Route::prefix('page')->name('page.')->controller(PageController::class)->middleware('can:edit page')->group(function () {
        Route::post('/save-preview-data/{page}', 'savePreviewData')->name('savePreviewData');
        Route::get('/preview/{page}', 'preview')->name('preview');

        Route::post('/add-template', 'addTemplateToPage')->name('addTemplateToPage');
        Route::post('/move-template', 'moveTemplate')->name('moveTemplate');
        Route::post('/remove-template', 'removeTemplate')->name('removeTemplate');
        Route::post('/set-homepage/{pageId}', 'setHomepage')->name('set-homepage');
        Route::post('/save-template/{page}', 'updateTemplateData')->name('updateTemplateData');
        Route::get('/{page}/linked-pages', 'getLinkedPages')->name('getLinkedPages');
    });

    // Authentication / User Management
    Route::resource('user', UserController::class)->except(['show'])->middleware('can:edit user');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/trash', [TrashController::class, 'index'])->name('trash.index');

    // Footer management
    Route::get('/footer', [FooterController::class, 'index'])->name('footer.index')->middleware('can:edit footer');
    Route::post('/footer', [FooterController::class, 'store'])->middleware('can:edit footer');
    Route::resource('/socials', SocialsController::class)->except(['show', 'index'])->middleware('can:edit footer');

    Route::resource('/event', EventsController::class)->except(['show'])->middleware('can:edit event');

    Route::post('/event/save-preview-data/{id?}', [EventsController::class, 'savePreviewData'])->name('event.savePreviewData')->middleware('can:edit event');
    Route::get('/event/preview', [EventsController::class, 'preview'])->name('event.preview')->middleware('can:edit event');

    Route::resource('/sponsors', SponsorController::class)->except(['show'])->middleware('can:edit sponsor');

    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings')->middleware('can:edit settings');
    Route::post('/update-color', [SettingsController::class, 'updateColor'])->name('update-color')->middleware('can:edit settings');
    Route::post('/update-favicon', [SettingsController::class, 'updateFavicon'])->name('update-favicon')->middleware('can:edit settings');
    Route::post('/update-logo', [SettingsController::class, 'updateLogo'])->name('update-logo')->middleware('can:edit settings');

    Route::prefix('nav')->name('nav.')->controller(NavController::class)->middleware('can:edit nav')->group(function () {
        Route::resource('/', NavController::class)->except(['create', 'store', 'update', 'edit', 'destroy']);
        Route::get('/create/{id?}', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::put('/{navItem}', 'update')->name('update');
        Route::get('/{navItem}/edit', 'edit')->name('edit');
        Route::delete('/{navItem}', 'destroy')->name('destroy');
        Route::post('/move-nav-item', 'moveNavItem')->name('moveNavItem');
    });

    Route::resource('/media', MediaController::class)->except(['show'])->middleware('can:edit media');

    Route::resource('/post', PostsController::class)->except(['show'])->middleware('can:edit post');
    Route::get('/post/{post}/show-sent', [PostsController::class, 'showSent'])->name('post.showSent')->middleware('can:edit post');
    Route::post('/post/{post}/accept-post', [PostsController::class, 'acceptPost'])->name('post.acceptPost')->middleware('can:edit post');

    Route::resource('/post-category', PostCategoryController::class)->only(['store', 'update'])->middleware('can:edit post');

    Route::get('/logbook', [LogController::class, 'index'])->name('admin.logbook')->middleware('can:see log');
    Route::get('/log/{log}', [LogController::class, 'show'])->name('admin.logbook.show')->middleware('can:see log');
    Route::post('/log/{log}/favorite', [LogController::class, 'favoriteOrUnfavorite'])->name('admin.logbook.favorite')->middleware('can:see log');
});

Route::get('404', function () {
    return view('errors.404');
})->name('404');

Route::get('/evenementen/{slug}', [EventsController::class, 'show'])->name('event.show');

Route::get('/post/send', [PostsController::class, 'send'])->name('post.send');
Route::post('/post/store-send', [PostsController::class, 'storeSend'])->name('post.storeSend');

Route::get('/posts/{slug}', [PostsController::class, 'show'])->name('post.show');

Route::get('/albums/{slug}', [AlbumController::class, 'show'])->name('album.show');

Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('login', [UserController::class, 'loginForm'])->name('auth.login');
    Route::post('login', [UserController::class, 'login']);
    Route::get('forgot-password', [ForgotPasswordController::class, 'forgotPasswordForm'])->name('password.forgot');
    Route::post('forgot-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.forgot.submit');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'resetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.reset.submit');
});

// This route should be at the end of the file
Route::get('/{slug?}', [PageController::class, 'show'])->name('page.show');
