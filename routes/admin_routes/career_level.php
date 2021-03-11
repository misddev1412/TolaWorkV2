<?php

/* * ******  CareerLevel Start ********** */
Route::get('list-career-levels', array_merge(['uses' => 'Admin\CareerLevelController@indexCareerLevels'], $all_users))->name('list.career.levels');
Route::get('create-career-level', array_merge(['uses' => 'Admin\CareerLevelController@createCareerLevel'], $all_users))->name('create.career.level');
Route::post('store-career-level', array_merge(['uses' => 'Admin\CareerLevelController@storeCareerLevel'], $all_users))->name('store.career.level');
Route::get('edit-career-level/{id}', array_merge(['uses' => 'Admin\CareerLevelController@editCareerLevel'], $all_users))->name('edit.career.level');
Route::put('update-career-level/{id}', array_merge(['uses' => 'Admin\CareerLevelController@updateCareerLevel'], $all_users))->name('update.career.level');
Route::delete('delete-career-level', array_merge(['uses' => 'Admin\CareerLevelController@deleteCareerLevel'], $all_users))->name('delete.career.level');
Route::get('fetch-career.levels', array_merge(['uses' => 'Admin\CareerLevelController@fetchCareerLevelsData'], $all_users))->name('fetch.data.career.levels');
Route::put('make-active-career-level', array_merge(['uses' => 'Admin\CareerLevelController@makeActiveCareerLevel'], $all_users))->name('make.active.career.level');
Route::put('make-not-active-career-level', array_merge(['uses' => 'Admin\CareerLevelController@makeNotActiveCareerLevel'], $all_users))->name('make.not.active.career.level');
Route::get('sort-career-levels', array_merge(['uses' => 'Admin\CareerLevelController@sortCareerLevels'], $all_users))->name('sort.career.levels');
Route::get('career-level-sort-data', array_merge(['uses' => 'Admin\CareerLevelController@careerLevelSortData'], $all_users))->name('career.level.sort.data');
Route::put('career-level-sort-update', array_merge(['uses' => 'Admin\CareerLevelController@careerLevelSortUpdate'], $all_users))->name('career.level.sort.update');
/* * ****** End CareerLevel ********** */