<?php

/* * ******  SalaryPeriod Start ********** */
Route::get('list-salary-periods', array_merge(['uses' => 'Admin\SalaryPeriodController@indexSalaryPeriods'], $all_users))->name('list.salary.periods');
Route::get('create-salary-period', array_merge(['uses' => 'Admin\SalaryPeriodController@createSalaryPeriod'], $all_users))->name('create.salary.period');
Route::post('store-salary-period', array_merge(['uses' => 'Admin\SalaryPeriodController@storeSalaryPeriod'], $all_users))->name('store.salary.period');
Route::get('edit-salary-period/{id}', array_merge(['uses' => 'Admin\SalaryPeriodController@editSalaryPeriod'], $all_users))->name('edit.salary.period');
Route::put('update-salary-period/{id}', array_merge(['uses' => 'Admin\SalaryPeriodController@updateSalaryPeriod'], $all_users))->name('update.salary.period');
Route::delete('delete-salary-period', array_merge(['uses' => 'Admin\SalaryPeriodController@deleteSalaryPeriod'], $all_users))->name('delete.salary.period');
Route::get('fetch-salary.periods', array_merge(['uses' => 'Admin\SalaryPeriodController@fetchSalaryPeriodsData'], $all_users))->name('fetch.data.salary.periods');
Route::put('make-active-salary-period', array_merge(['uses' => 'Admin\SalaryPeriodController@makeActiveSalaryPeriod'], $all_users))->name('make.active.salary.period');
Route::put('make-not-active-salary-period', array_merge(['uses' => 'Admin\SalaryPeriodController@makeNotActiveSalaryPeriod'], $all_users))->name('make.not.active.salary.period');
Route::get('sort-salary-periods', array_merge(['uses' => 'Admin\SalaryPeriodController@sortSalaryPeriods'], $all_users))->name('sort.salary.periods');
Route::get('salary-period-sort-data', array_merge(['uses' => 'Admin\SalaryPeriodController@salaryPeriodSortData'], $all_users))->name('salary.period.sort.data');
Route::put('salary-period-sort-update', array_merge(['uses' => 'Admin\SalaryPeriodController@salaryPeriodSortUpdate'], $all_users))->name('salary.period.sort.update');
/* * ****** End SalaryPeriod ********** */