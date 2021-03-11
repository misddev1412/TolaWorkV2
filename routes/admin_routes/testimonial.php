<?php

/* * ******  Testimonial Start ********** */
Route::get('list-testimonials', array_merge(['uses' => 'Admin\TestimonialController@indexTestimonials'], $all_users))->name('list.testimonials');
Route::get('create-testimonial', array_merge(['uses' => 'Admin\TestimonialController@createTestimonial'], $all_users))->name('create.testimonial');
Route::post('store-testimonial', array_merge(['uses' => 'Admin\TestimonialController@storeTestimonial'], $all_users))->name('store.testimonial');
Route::get('edit-testimonial/{id}', array_merge(['uses' => 'Admin\TestimonialController@editTestimonial'], $all_users))->name('edit.testimonial');
Route::put('update-testimonial/{id}', array_merge(['uses' => 'Admin\TestimonialController@updateTestimonial'], $all_users))->name('update.testimonial');
Route::delete('delete-testimonial', array_merge(['uses' => 'Admin\TestimonialController@deleteTestimonial'], $all_users))->name('delete.testimonial');
Route::get('fetch-testimonials', array_merge(['uses' => 'Admin\TestimonialController@fetchTestimonialsData'], $all_users))->name('fetch.data.testimonials');
Route::put('make-active-testimonial', array_merge(['uses' => 'Admin\TestimonialController@makeActiveTestimonial'], $all_users))->name('make.active.testimonial');
Route::put('make-not-active-testimonial', array_merge(['uses' => 'Admin\TestimonialController@makeNotActiveTestimonial'], $all_users))->name('make.not.active.testimonial');
Route::get('sort-testimonials', array_merge(['uses' => 'Admin\TestimonialController@sortTestimonials'], $all_users))->name('sort.testimonials');
Route::get('testimonial-sort-data', array_merge(['uses' => 'Admin\TestimonialController@testimonialSortData'], $all_users))->name('testimonial.sort.data');
Route::put('testimonial-sort-update', array_merge(['uses' => 'Admin\TestimonialController@testimonialSortUpdate'], $all_users))->name('testimonial.sort.update');
/* * ****** End Testimonial ********** */