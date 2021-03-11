<?php

/* * ******  FAQ Field Start ********** */
Route::get('list-faqs', array_merge(['uses' => 'Admin\FaqController@indexFaqs'], $all_users))->name('list.faqs');
Route::get('create-faq', array_merge(['uses' => 'Admin\FaqController@createFaq'], $all_users))->name('create.faq');
Route::post('store-faq', array_merge(['uses' => 'Admin\FaqController@storeFaq'], $all_users))->name('store.faq');
Route::get('edit-faq/{id}/{industry_id?}', array_merge(['uses' => 'Admin\FaqController@editFaq'], $all_users))->name('edit.faq');
Route::put('update-faq/{id}', array_merge(['uses' => 'Admin\FaqController@updateFaq'], $all_users))->name('update.faq');
Route::delete('delete-faq', array_merge(['uses' => 'Admin\FaqController@deleteFaq'], $all_users))->name('delete.faq');
Route::get('fetch-faqs', array_merge(['uses' => 'Admin\FaqController@fetchFaqsData'], $all_users))->name('fetch.data.faqs');
Route::get('sort-faq', array_merge(['uses' => 'Admin\FaqController@sortFaqs'], $all_users))->name('sort.faqs');
Route::get('faq-sort-data', array_merge(['uses' => 'Admin\FaqController@faqSortData'], $all_users))->name('faq.sort.data');
Route::put('faq-sort-update', array_merge(['uses' => 'Admin\FaqController@faqSortUpdate'], $all_users))->name('faq.sort.update');
/* * ****** End FAQ Field ********** */
?>