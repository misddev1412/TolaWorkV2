<?php

/* * ******  JobExperience Start ********** */
Route::get('list-job-experiences', array_merge(['uses' => 'Admin\JobExperienceController@indexJobExperiences'], $all_users))->name('list.job.experiences');
Route::get('create-job-experience', array_merge(['uses' => 'Admin\JobExperienceController@createJobExperience'], $all_users))->name('create.job.experience');
Route::post('store-job-experience', array_merge(['uses' => 'Admin\JobExperienceController@storeJobExperience'], $all_users))->name('store.job.experience');
Route::get('edit-job-experience/{id}', array_merge(['uses' => 'Admin\JobExperienceController@editJobExperience'], $all_users))->name('edit.job.experience');
Route::put('update-job-experience/{id}', array_merge(['uses' => 'Admin\JobExperienceController@updateJobExperience'], $all_users))->name('update.job.experience');
Route::delete('delete-job-experience', array_merge(['uses' => 'Admin\JobExperienceController@deleteJobExperience'], $all_users))->name('delete.job.experience');
Route::get('fetch-job.experiences', array_merge(['uses' => 'Admin\JobExperienceController@fetchJobExperiencesData'], $all_users))->name('fetch.data.job.experiences');
Route::put('make-active-job-experience', array_merge(['uses' => 'Admin\JobExperienceController@makeActiveJobExperience'], $all_users))->name('make.active.job.experience');
Route::put('make-not-active-job-experience', array_merge(['uses' => 'Admin\JobExperienceController@makeNotActiveJobExperience'], $all_users))->name('make.not.active.job.experience');
Route::get('sort-job-experiences', array_merge(['uses' => 'Admin\JobExperienceController@sortJobExperiences'], $all_users))->name('sort.job.experiences');
Route::get('job-experience-sort-data', array_merge(['uses' => 'Admin\JobExperienceController@jobExperienceSortData'], $all_users))->name('job.experience.sort.data');
Route::put('job-experience-sort-update', array_merge(['uses' => 'Admin\JobExperienceController@jobExperienceSortUpdate'], $all_users))->name('job.experience.sort.update');
/* * ****** End JobExperience ********** */