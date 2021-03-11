<?php

namespace App\Traits;

use DB;
use App\User;
use App\Country;
use App\State;
use App\City;
use App\CareerLevel;
use App\FunctionalArea;
use App\Gender;
use App\ProfileSkill;
use App\JobExperience;

trait FetchJobSeekers
{

    private $fields = array(
        'users.id',
        'users.first_name',
        'users.middle_name',
        'users.last_name',
        'users.name',
        'users.email',
        'users.father_name',
        'users.date_of_birth',
        'users.gender_id',
        'users.marital_status_id',
        'users.nationality_id',
        'users.national_id_card_number',
        'users.country_id',
        'users.state_id',
        'users.city_id',
        'users.phone',
        'users.mobile_num',
        'users.job_experience_id',
        'users.career_level_id',
        'users.industry_id',
        'users.functional_area_id',
        'users.current_salary',
        'users.expected_salary',
        'users.salary_currency',
        'users.street_address',
        'users.is_active',
        'users.verified',
        'users.verification_token',
        'users.provider',
        'users.provider_id',
        'users.password',
        'users.remember_token',
        'users.image',
        'users.lang',
        'users.created_at',
        'users.updated_at',
        'users.is_immediate_available',
        'users.num_profile_views',
        'users.package_id',
        'users.package_start_date',
        'users.package_end_date',
        'users.jobs_quota',
        'users.availed_jobs_quota',
        'users.search'
    );

    public function fetchJobSeekers($search = '', $industry_ids = array(), $functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(), $career_level_ids = array(), $gender_ids = array(), $job_experience_ids = array(), $current_salary = 0, $expected_salary = 0, $salary_currency = '', $order_by = 'id', $limit = 10)
    {
        $asc_desc = 'DESC';
        $query = User::select($this->fields);
        $query = $this->createQuery($query, $search, $industry_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $career_level_ids, $gender_ids, $job_experience_ids, $current_salary, $expected_salary, $salary_currency);

        $query->orderBy('users.id', 'DESC');
        //echo $query->toSql();exit;
        return $query->paginate($limit);
    }

    public function fetchIdsArray($search = '', $industry_ids = array(), $functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(), $career_level_ids = array(), $gender_ids = array(), $job_experience_ids = array(), $current_salary = 0, $expected_salary = 0, $salary_currency = '', $field = 'users.id')
    {
        $query = User::select($field);
        $query = $this->createQuery($query, $search, $industry_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $career_level_ids, $gender_ids, $job_experience_ids, $current_salary, $expected_salary, $salary_currency);

        $array = $query->pluck($field)->toArray();
        return array_unique($array);
    }

    public function createQuery($query, $search = '', $industry_ids = array(), $functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(), $career_level_ids = array(), $gender_ids = array(), $job_experience_ids = array(), $current_salary = 0, $expected_salary = 0, $salary_currency = '')
    {
        $query->where('users.is_active', 1);
        if ($search != '') {
            $query = $query->whereRaw("MATCH (`search`) AGAINST ('$search*' IN BOOLEAN MODE)");
        }
        if (isset($industry_ids[0])) {
            $query->whereIn('users.industry_id', $industry_ids);
        }
        if (isset($functional_area_ids[0])) {
            $query->whereIn('users.functional_area_id', $functional_area_ids);
        }
        if (isset($country_ids[0])) {
            $query->whereIn('users.country_id', $country_ids);
        }
        if (isset($state_ids[0])) {
            $query->whereIn('users.state_id', $state_ids);
        }
        if (isset($city_ids[0])) {
            $query->whereIn('users.city_id', $city_ids);
        }
        if (isset($career_level_ids[0])) {
            $query->whereIn('users.career_level_id', $career_level_ids);
        }
        if (isset($gender_ids[0])) {
            $query->whereIn('users.gender_id', $gender_ids);
        }
        if (isset($job_experience_ids[0])) {
            $query->whereIn('users.job_experience_id', $job_experience_ids);
        }
        if ((int) $current_salary > 0) {
            $query->where('users.current_salary', '>=', $current_salary);
        }
        if ((int) $expected_salary > 0) {
            $query = $query->whereRaw("(`users`.`expected_salary` - $expected_salary) >= 0");
            //$query->where('jobs.salary_to', '<=', $salary_to);
        }
        if (!empty(trim($salary_currency))) {
            $query->where('users.salary_currency', 'like', $salary_currency);
        }
        return $query;
    }

    public function fetchSkillIdsArray($jobSeekerIdsArray = array())
    {
        $query = ProfileSkill::select('job_skill_id');
        $query->whereIn('user_id', $jobSeekerIdsArray);

        $array = $query->pluck('job_skill_id')->toArray();
        return array_unique($array);
    }

    private function getSEO($functional_area_ids = array(), $country_ids = array(), $state_ids = array(), $city_ids = array(), $career_level_ids = array(), $gender_ids = array(), $job_experience_ids = array())
    {
        $description = 'Users ';
        $keywords = '';
        if (isset($functional_area_ids[0])) {
            foreach ($functional_area_ids as $functional_area_id) {
                $functional_area = FunctionalArea::where('functional_area_id', $functional_area_id)->lang()->first();
                if (null !== $functional_area) {
                    $description .= ' ' . $functional_area->functional_area;
                    $keywords .= $functional_area->functional_area . ',';
                }
            }
        }
        if (isset($country_ids[0])) {
            foreach ($country_ids as $country_id) {
                $country = Country::where('country_id', $country_id)->lang()->first();
                if (null !== $country) {
                    $description .= ' ' . $country->country;
                    $keywords .= $country->country . ',';
                }
            }
        }
        if (isset($state_ids[0])) {
            foreach ($state_ids as $state_id) {
                $state = State::where('state_id', $state_id)->lang()->first();
                if (null !== $state) {
                    $description .= ' ' . $state->state;
                    $keywords .= $state->state . ',';
                }
            }
        }
        if (isset($city_ids[0])) {
            foreach ($city_ids as $city_id) {
                $city = City::where('city_id', $city_id)->lang()->first();
                if (null !== $city) {
                    $description .= ' ' . $city->city;
                    $keywords .= $city->city . ',';
                }
            }
        }
        if (isset($career_level_ids[0])) {
            foreach ($career_level_ids as $career_level_id) {
                $career_level = CareerLevel::where('career_level_id', $career_level_id)->lang()->first();
                if (null !== $career_level) {
                    $description .= ' ' . $career_level->career_level;
                    $keywords .= $career_level->career_level . ',';
                }
            }
        }
        if (isset($gender_ids[0])) {
            foreach ($gender_ids as $gender_id) {
                $gender = Gender::where('gender_id', $gender_id)->lang()->first();
                if (null !== $gender) {
                    $description .= ' ' . $gender->gender;
                    $keywords .= $gender->gender . ',';
                }
            }
        }
        if (isset($job_experience_ids[0])) {
            foreach ($job_experience_ids as $job_experience_id) {
                $job_experience = JobExperience::where('job_experience_id', $job_experience_id)->lang()->first();
                if (null !== $job_experience) {
                    $description .= ' ' . $job_experience->job_experience;
                    $keywords .= $job_experience->job_experience . ',';
                }
            }
        }
        return ['keywords' => $keywords, 'description' => $description];
    }

}
