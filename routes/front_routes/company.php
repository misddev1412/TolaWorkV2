<?php
Route::get('company-home', 'Company\CompanyController@index')->name('company.home');
Route::get('company-profile', 'Company\CompanyController@companyProfile')->name('company.profile');
Route::put('update-company-profile', 'Company\CompanyController@updateCompanyProfile')->name('update.company.profile');
Route::get('posted-jobs', 'Company\CompanyController@postedJobs')->name('posted.jobs');
Route::get('company/{slug}', 'Company\CompanyController@companyDetail')->name('company.detail');
Route::post('contact-company-message-send', 'Company\CompanyController@sendContactForm')->name('contact.company.message.send');
Route::post('contact-applicant-message-send', 'Company\CompanyController@sendApplicantContactForm')->name('contact.applicant.message.send');
Route::get('list-applied-users/{job_id}', 'Company\CompanyController@listAppliedUsers')->name('list.applied.users');
Route::get('list-favourite-applied-users/{job_id}', 'Company\CompanyController@listFavouriteAppliedUsers')->name('list.favourite.applied.users');
Route::get('add-to-favourite-applicant/{application_id}/{user_id}/{job_id}/{company_id}', 'Company\CompanyController@addToFavouriteApplicant')->name('add.to.favourite.applicant');
Route::get('remove-from-favourite-applicant/{application_id}/{user_id}/{job_id}/{company_id}', 'Company\CompanyController@removeFromFavouriteApplicant')->name('remove.from.favourite.applicant');
Route::get('applicant-profile/{application_id}', 'Company\CompanyController@applicantProfile')->name('applicant.profile');
Route::get('user-profile/{id}', 'Company\CompanyController@userProfile')->name('user.profile');
Route::get('company-followers', 'Company\CompanyController@companyFollowers')->name('company.followers');
Route::get('company-messages', 'Company\CompanyController@companyMessages')->name('company.messages');
Route::get('company-message-detail/{id}', 'Company\CompanyController@companyMessageDetail')->name('company.message.detail');