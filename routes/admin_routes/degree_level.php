<?php

/* * ******  DegreeLevel Start ********** */
Route::get('list-degree-levels', array_merge(['uses' => 'Admin\DegreeLevelController@indexDegreeLevels'], $all_users))->name('list.degree.levels');
Route::get('create-degree-level', array_merge(['uses' => 'Admin\DegreeLevelController@createDegreeLevel'], $all_users))->name('create.degree.level');
Route::post('store-degree-level', array_merge(['uses' => 'Admin\DegreeLevelController@storeDegreeLevel'], $all_users))->name('store.degree.level');
Route::get('edit-degree-level/{id}', array_merge(['uses' => 'Admin\DegreeLevelController@editDegreeLevel'], $all_users))->name('edit.degree.level');
Route::put('update-degree-level/{id}', array_merge(['uses' => 'Admin\DegreeLevelController@updateDegreeLevel'], $all_users))->name('update.degree.level');
Route::delete('delete-degree-level', array_merge(['uses' => 'Admin\DegreeLevelController@deleteDegreeLevel'], $all_users))->name('delete.degree.level');
Route::get('fetch-degree.levels', array_merge(['uses' => 'Admin\DegreeLevelController@fetchDegreeLevelsData'], $all_users))->name('fetch.data.degree.levels');
Route::put('make-active-degree-level', array_merge(['uses' => 'Admin\DegreeLevelController@makeActiveDegreeLevel'], $all_users))->name('make.active.degree.level');
Route::put('make-not-active-degree-level', array_merge(['uses' => 'Admin\DegreeLevelController@makeNotActiveDegreeLevel'], $all_users))->name('make.not.active.degree.level');
Route::get('sort-degree-levels', array_merge(['uses' => 'Admin\DegreeLevelController@sortDegreeLevels'], $all_users))->name('sort.degree.levels');
Route::get('degree-level-sort-data', array_merge(['uses' => 'Admin\DegreeLevelController@degreeLevelSortData'], $all_users))->name('degree.level.sort.data');
Route::put('degree-level-sort-update', array_merge(['uses' => 'Admin\DegreeLevelController@degreeLevelSortUpdate'], $all_users))->name('degree.level.sort.update');
/* * ****** End DegreeLevel ********** */