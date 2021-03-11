<?php

/* * ******  MaritalStatus Start ********** */
Route::get('list-marital-statuses', array_merge(['uses' => 'Admin\MaritalStatusController@indexMaritalStatuses'], $all_users))->name('list.marital.statuses');
Route::get('create-marital-status', array_merge(['uses' => 'Admin\MaritalStatusController@createMaritalStatus'], $all_users))->name('create.marital.status');
Route::post('store-marital-status', array_merge(['uses' => 'Admin\MaritalStatusController@storeMaritalStatus'], $all_users))->name('store.marital.status');
Route::get('edit-marital-status/{id}', array_merge(['uses' => 'Admin\MaritalStatusController@editMaritalStatus'], $all_users))->name('edit.marital.status');
Route::put('update-marital-status/{id}', array_merge(['uses' => 'Admin\MaritalStatusController@updateMaritalStatus'], $all_users))->name('update.marital.status');
Route::delete('delete-marital-status', array_merge(['uses' => 'Admin\MaritalStatusController@deleteMaritalStatus'], $all_users))->name('delete.marital.status');
Route::get('fetch-marital.statuses', array_merge(['uses' => 'Admin\MaritalStatusController@fetchMaritalStatusesData'], $all_users))->name('fetch.data.marital.statuses');
Route::put('make-active-marital-status', array_merge(['uses' => 'Admin\MaritalStatusController@makeActiveMaritalStatus'], $all_users))->name('make.active.marital.status');
Route::put('make-not-active-marital-status', array_merge(['uses' => 'Admin\MaritalStatusController@makeNotActiveMaritalStatus'], $all_users))->name('make.not.active.marital.status');
Route::get('sort-marital-statuses', array_merge(['uses' => 'Admin\MaritalStatusController@sortMaritalStatuses'], $all_users))->name('sort.marital.statuses');
Route::get('marital-status-sort-data', array_merge(['uses' => 'Admin\MaritalStatusController@maritalStatusSortData'], $all_users))->name('marital.status.sort.data');
Route::put('marital-status-sort-update', array_merge(['uses' => 'Admin\MaritalStatusController@maritalStatusSortUpdate'], $all_users))->name('marital.status.sort.update');
/* * ****** End MaritalStatus ********** */