<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('cron', 'CronController@cron')->name('cron');

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{ticket}', 'replyTicket')->name('reply');
    Route::post('close/{ticket}', 'closeTicket')->name('close');
    Route::get('download/{ticket}', 'ticketDownload')->name('download');
});

Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
    Route::get('blog', 'blogs')->name('blog');
    Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');
    Route::get('properties', 'property')->name('property');
        //mine for foodCommunityPortal
    Route::get('product', 'foodCommunityPortal')->name('foodCommunityPortal');
    Route::get('property/{slug}/{id}', 'propertyDetails')->name('property.details');
    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');
    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');
    Route::post('/subscribe', 'addSubscriber')->name('subscribe');
    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
    Route::get('/user/fdcomdashboard', [UserController::class, 'fdComHome'])->name('user.fdcomdashboard');
    
});
