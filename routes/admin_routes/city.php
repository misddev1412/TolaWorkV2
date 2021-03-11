<?php

/* * ******  City Start ********** */
Route::get('list-cities', array_merge(['uses' => 'Admin\CityController@indexCities'], $all_users))->name('list.cities');
Route::get('create-city', array_merge(['uses' => 'Admin\CityController@createCity'], $all_users))->name('create.city');
Route::post('store-city', array_merge(['uses' => 'Admin\CityController@storeCity'], $all_users))->name('store.city');
Route::get('edit-city/{id}', array_merge(['uses' => 'Admin\CityController@editCity'], $all_users))->name('edit.city');
Route::put('update-city/{id}', array_merge(['uses' => 'Admin\CityController@updateCity'], $all_users))->name('update.city');
Route::delete('delete-city', array_merge(['uses' => 'Admin\CityController@deleteCity'], $all_users))->name('delete.city');
Route::get('fetch-cities', array_merge(['uses' => 'Admin\CityController@fetchCitiesData'], $all_users))->name('fetch.data.cities');
Route::put('make-active-city', array_merge(['uses' => 'Admin\CityController@makeActiveCity'], $all_users))->name('make.active.city');
Route::put('make-not-active-city', array_merge(['uses' => 'Admin\CityController@makeNotActiveCity'], $all_users))->name('make.not.active.city');
Route::get('sort-cities', array_merge(['uses' => 'Admin\CityController@sortCities'], $all_users))->name('sort.cities');
Route::get('city-sort-data', array_merge(['uses' => 'Admin\CityController@citySortData'], $all_users))->name('city.sort.data');
Route::put('city-sort-update', array_merge(['uses' => 'Admin\CityController@citySortUpdate'], $all_users))->name('city.sort.update');
/* * ****** End City ********** */