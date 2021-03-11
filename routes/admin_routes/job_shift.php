<?php

/* * ******  JobShift Start ********** */
Route::get('list-job-shifts', array_merge(['uses' => 'Admin\JobShiftController@indexJobShifts'], $all_users))->name('list.job.shifts');
Route::get('create-job-shift', array_merge(['uses' => 'Admin\JobShiftController@createJobShift'], $all_users))->name('create.job.shift');
Route::post('store-job-shift', array_merge(['uses' => 'Admin\JobShiftController@storeJobShift'], $all_users))->name('store.job.shift');
Route::get('edit-job-shift/{id}', array_merge(['uses' => 'Admin\JobShiftController@editJobShift'], $all_users))->name('edit.job.shift');
Route::put('update-job-shift/{id}', array_merge(['uses' => 'Admin\JobShiftController@updateJobShift'], $all_users))->name('update.job.shift');
Route::delete('delete-job-shift', array_merge(['uses' => 'Admin\JobShiftController@deleteJobShift'], $all_users))->name('delete.job.shift');
Route::get('fetch-job.shifts', array_merge(['uses' => 'Admin\JobShiftController@fetchJobShiftsData'], $all_users))->name('fetch.data.job.shifts');
Route::put('make-active-job-shift', array_merge(['uses' => 'Admin\JobShiftController@makeActiveJobShift'], $all_users))->name('make.active.job.shift');
Route::put('make-not-active-job-shift', array_merge(['uses' => 'Admin\JobShiftController@makeNotActiveJobShift'], $all_users))->name('make.not.active.job.shift');
Route::get('sort-job-shifts', array_merge(['uses' => 'Admin\JobShiftController@sortJobShifts'], $all_users))->name('sort.job.shifts');
Route::get('job-shift-sort-data', array_merge(['uses' => 'Admin\JobShiftController@jobShiftSortData'], $all_users))->name('job.shift.sort.data');
Route::put('job-shift-sort-update', array_merge(['uses' => 'Admin\JobShiftController@jobShiftSortUpdate'], $all_users))->name('job.shift.sort.update');
/* * ****** End JobShift ********** */