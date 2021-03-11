<?php

Route::prefix('company')->name('company.')->group(function () {
    Route::get('/', 'Company\Auth\LoginController@showLoginForm');
    Route::get('/login', 'Company\Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Company\Auth\LoginController@login');
    Route::post('/logout', 'Company\Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('/register', 'Company\Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'Company\Auth\RegisterController@register');
    Route::get('/password/reset', 'Company\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email', 'Company\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset/{token}', 'Company\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset', 'Company\Auth\ResetPasswordController@reset');
});
