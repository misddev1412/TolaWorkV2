<?php

/* * ******  JobType Start ********** */
Route::get('list-job-types', array_merge(['uses' => 'Admin\JobTypeController@indexJobTypes'], $all_users))->name('list.job.types');
Route::get('create-job-type', array_merge(['uses' => 'Admin\JobTypeController@createJobType'], $all_users))->name('create.job.type');
Route::post('store-job-type', array_merge(['uses' => 'Admin\JobTypeController@storeJobType'], $all_users))->name('store.job.type');
Route::get('edit-job-type/{id}', array_merge(['uses' => 'Admin\JobTypeController@editJobType'], $all_users))->name('edit.job.type');
Route::put('update-job-type/{id}', array_merge(['uses' => 'Admin\JobTypeController@updateJobType'], $all_users))->name('update.job.type');
Route::delete('delete-job-type', array_merge(['uses' => 'Admin\JobTypeController@deleteJobType'], $all_users))->name('delete.job.type');
Route::get('fetch-job.types', array_merge(['uses' => 'Admin\JobTypeController@fetchJobTypesData'], $all_users))->name('fetch.data.job.types');
Route::put('make-active-job-type', array_merge(['uses' => 'Admin\JobTypeController@makeActiveJobType'], $all_users))->name('make.active.job.type');
Route::put('make-not-active-job-type', array_merge(['uses' => 'Admin\JobTypeController@makeNotActiveJobType'], $all_users))->name('make.not.active.job.type');
Route::get('sort-job-types', array_merge(['uses' => 'Admin\JobTypeController@sortJobTypes'], $all_users))->name('sort.job.types');
Route::get('job-type-sort-data', array_merge(['uses' => 'Admin\JobTypeController@jobTypeSortData'], $all_users))->name('job.type.sort.data');
Route::put('job-type-sort-update', array_merge(['uses' => 'Admin\JobTypeController@jobTypeSortUpdate'], $all_users))->name('job.type.sort.update');
/* * ****** End JobType ********** */