<?php

/* * ******  State Start ********** */
Route::get('list-states', array_merge(['uses' => 'Admin\StateController@indexStates'], $all_users))->name('list.states');
Route::get('create-state', array_merge(['uses' => 'Admin\StateController@createState'], $all_users))->name('create.state');
Route::post('store-state', array_merge(['uses' => 'Admin\StateController@storeState'], $all_users))->name('store.state');
Route::get('edit-state/{id}', array_merge(['uses' => 'Admin\StateController@editState'], $all_users))->name('edit.state');
Route::put('update-state/{id}', array_merge(['uses' => 'Admin\StateController@updateState'], $all_users))->name('update.state');
Route::delete('delete-state', array_merge(['uses' => 'Admin\StateController@deleteState'], $all_users))->name('delete.state');
Route::get('fetch-states', array_merge(['uses' => 'Admin\StateController@fetchStatesData'], $all_users))->name('fetch.data.states');
Route::put('make-active-state', array_merge(['uses' => 'Admin\StateController@makeActiveState'], $all_users))->name('make.active.state');
Route::put('make-not-active-state', array_merge(['uses' => 'Admin\StateController@makeNotActiveState'], $all_users))->name('make.not.active.state');
Route::get('sort-states', array_merge(['uses' => 'Admin\StateController@sortStates'], $all_users))->name('sort.states');
Route::get('state-sort-data', array_merge(['uses' => 'Admin\StateController@stateSortData'], $all_users))->name('state.sort.data');
Route::put('state-sort-update', array_merge(['uses' => 'Admin\StateController@stateSortUpdate'], $all_users))->name('state.sort.update');
/* * ****** End State ********** */