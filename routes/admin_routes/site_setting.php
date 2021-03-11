<?php

/* * ******  SiteSetting Start ********** */
Route::get('edit-site-setting', array_merge(['uses' => 'Admin\SiteSettingController@editsiteSetting'], $all_users))->name('edit.site.setting');
Route::put('update-site-setting', array_merge(['uses' => 'Admin\SiteSettingController@updatesiteSetting'], $all_users))->name('update.site.setting');
/* * ****** End SiteSetting ********** */
?>