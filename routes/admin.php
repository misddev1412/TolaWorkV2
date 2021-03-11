<?php

$all_users = ['allowed_roles' => ['SUP_ADM', 'SUB_ADM']];
$sup_only = ['allowed_roles' => 'SUP_ADM'];

Route::get('/home', array_merge(['uses' => 'Admin\HomeController@index'], $all_users))->name('admin.home');
Route::post('tinymce-image_upload', array_merge(['uses' => 'Admin\TinyMceController@uploadImage'], $all_users))->name('tinymce.image_upload');

/************************************/

$real_path = realpath(__DIR__).DIRECTORY_SEPARATOR.'admin_routes'.DIRECTORY_SEPARATOR;

include_once($real_path .'admin_user.php');
include_once($real_path .'site_user.php');
include_once($real_path .'faq.php');
include_once($real_path .'seo.php');
include_once($real_path .'cms.php');
include_once($real_path .'site_setting.php');
include_once($real_path .'career_level.php');
include_once($real_path .'country.php');
include_once($real_path .'country_detail.php');
include_once($real_path .'functional_area.php');
include_once($real_path .'gender.php');
include_once($real_path .'industry.php');
include_once($real_path .'job_experience.php');
include_once($real_path .'job_skill.php');
include_once($real_path .'job_title.php');
include_once($real_path .'job_type.php');
include_once($real_path .'job_shift.php');
include_once($real_path .'degree_level.php');
include_once($real_path .'degree_type.php');
include_once($real_path .'major_subject.php');
include_once($real_path .'language.php');
include_once($real_path .'state.php');
include_once($real_path .'city.php');
include_once($real_path .'result_type.php');
include_once($real_path .'language_level.php');
include_once($real_path .'marital_status.php');
include_once($real_path .'company.php');
include_once($real_path .'ownership_type.php');
include_once($real_path .'job.php');
include_once($real_path .'salary_period.php');
include_once($real_path .'package.php');
include_once($real_path .'video.php');
include_once($real_path .'testimonial.php');