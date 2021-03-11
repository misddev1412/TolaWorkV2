<?php
Route::get('job/{slug}', 'Job\JobController@jobDetail')->name('job.detail');
Route::get('apply/{slug}', 'Job\JobController@applyJob')->name('apply.job');
Route::post('apply/{slug}', 'Job\JobController@postApplyJob')->name('post.apply.job');
Route::get('jobs', 'Job\JobController@jobsBySearch')->name('job.list');
Route::get('add-to-favourite-job/{job_slug}', 'Job\JobController@addToFavouriteJob')->name('add.to.favourite');
Route::get('remove-from-favourite-job/{job_slug}', 'Job\JobController@removeFromFavouriteJob')->name('remove.from.favourite');
Route::get('my-job-applications', 'Job\JobController@myJobApplications')->name('my.job.applications');
Route::get('my-favourite-jobs', 'Job\JobController@myFavouriteJobs')->name('my.favourite.jobs');
Route::get('post-job', 'Job\JobPublishController@createFrontJob')->name('post.job');
Route::post('store-front-job', 'Job\JobPublishController@storeFrontJob')->name('store.front.job');
Route::get('edit-front-job/{id}', 'Job\JobPublishController@editFrontJob')->name('edit.front.job');
Route::put('update-front-job/{id}', 'Job\JobPublishController@updateFrontJob')->name('update.front.job');
Route::delete('delete-front-job', 'Job\JobPublishController@deleteJob')->name('delete.front.job');

Route::get('job-seekers', 'Job\JobSeekerController@jobSeekersBySearch')->name('job.seeker.list');