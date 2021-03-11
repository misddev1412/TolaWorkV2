<?php

/* * ******  Language Start ********** */
Route::get('list-languages', array_merge(['uses' => 'Admin\LanguageController@indexLanguages'], $all_users))->name('list.languages');
Route::get('create-language', array_merge(['uses' => 'Admin\LanguageController@createLanguage'], $all_users))->name('create.language');
Route::post('store-language', array_merge(['uses' => 'Admin\LanguageController@storeLanguage'], $all_users))->name('store.language');
Route::get('edit-language/{id}', array_merge(['uses' => 'Admin\LanguageController@editLanguage'], $all_users))->name('edit.language');
Route::put('update-language/{id}', array_merge(['uses' => 'Admin\LanguageController@updateLanguage'], $all_users))->name('update.language');
Route::delete('delete-language', array_merge(['uses' => 'Admin\LanguageController@deleteLanguage'], $all_users))->name('delete.language');
Route::get('fetch-languages', array_merge(['uses' => 'Admin\LanguageController@fetchLanguagesData'], $all_users))->name('fetch.data.languages');
Route::put('make-active-language', array_merge(['uses' => 'Admin\LanguageController@makeActiveLanguage'], $all_users))->name('make.active.language');
Route::put('make-default-language', array_merge(['uses' => 'Admin\LanguageController@makeDefaultLanguage'], $all_users))->name('make.default.language');
Route::put('make-not-active-language', array_merge(['uses' => 'Admin\LanguageController@makeNotActiveLanguage'], $all_users))->name('make.not.active.language');
/* * ****** End Language ********** */