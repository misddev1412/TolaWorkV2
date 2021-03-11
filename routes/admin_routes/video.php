<?php

/* * ******  Video Start ********** */
Route::get('list-videos', array_merge(['uses' => 'Admin\VideoController@indexVideos'], $all_users))->name('list.videos');
Route::get('create-video', array_merge(['uses' => 'Admin\VideoController@createVideo'], $all_users))->name('create.video');
Route::post('store-video', array_merge(['uses' => 'Admin\VideoController@storeVideo'], $all_users))->name('store.video');
Route::get('edit-video/{id}', array_merge(['uses' => 'Admin\VideoController@editVideo'], $all_users))->name('edit.video');
Route::put('update-video/{id}', array_merge(['uses' => 'Admin\VideoController@updateVideo'], $all_users))->name('update.video');
Route::delete('delete-video', array_merge(['uses' => 'Admin\VideoController@deleteVideo'], $all_users))->name('delete.video');
Route::get('fetch-videos', array_merge(['uses' => 'Admin\VideoController@fetchVideosData'], $all_users))->name('fetch.data.videos');
Route::put('make-active-video', array_merge(['uses' => 'Admin\VideoController@makeActiveVideo'], $all_users))->name('make.active.video');
Route::put('make-not-active-video', array_merge(['uses' => 'Admin\VideoController@makeNotActiveVideo'], $all_users))->name('make.not.active.video');
Route::get('sort-videos', array_merge(['uses' => 'Admin\VideoController@sortVideos'], $all_users))->name('sort.videos');
Route::get('video-sort-data', array_merge(['uses' => 'Admin\VideoController@videoSortData'], $all_users))->name('video.sort.data');
Route::put('video-sort-update', array_merge(['uses' => 'Admin\VideoController@videoSortUpdate'], $all_users))->name('video.sort.update');
/* * ****** End Video ********** */