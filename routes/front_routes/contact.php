<?php

Route::get('email-to-friend/{job_slug}', 'ContactController@emailToFriend')->name('email.to.friend');
Route::post('email-to-friend/{job_slug}', 'ContactController@emailToFriendPost')->name('email.to.friend');
Route::get('email-to-friend-thanks', 'ContactController@emailToFriendThanks')->name('email.to.friend.thanks');
Route::get('report-abuse/{job_slug}', 'ContactController@reportAbuse')->name('report.abuse');
Route::post('report-abuse/{job_slug}', 'ContactController@reportAbusePost')->name('report.abuse');
Route::get('report-abuse-thanks', 'ContactController@reportAbuseThanks')->name('report.abuse.thanks');
Route::get('report-abuse-company/{company_slug}', 'ContactController@reportAbuseCompany')->name('report.abuse.company');
Route::post('report-abuse-company/{company_slug}', 'ContactController@reportAbuseCompanyPost')->name('report.abuse.company');
Route::get('report-abuse-company-thanks', 'ContactController@reportAbuseCompanyThanks')->name('report.abuse.company.thanks');
