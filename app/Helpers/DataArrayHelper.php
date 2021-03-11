<?php

namespace App\Helpers;

use Request;
use App\Language;
use App\DegreeLevel;
use App\DegreeType;
use App\User;
use App\Gender;
use App\Category;
use App\Country;
use App\CountryDetail;
use App\State;
use App\City;
use App\CareerLevel;
use App\Industry;
use App\FunctionalArea;
use App\MajorSubject;
use App\ResultType;
use App\LanguageLevel;
use App\JobSkill;
use App\JobExperience;
use App\JobType;
use App\JobShift;
use App\JobTitle;
use App\Company;
use App\MaritalStatus;
use App\OwnershipType;
use App\SalaryPeriod;
use App\Video;
use App\Testimonial;
use App\Slider;

class DataArrayHelper
{

    public static function defaultStatesArray($country_id)
    {
        $array = State::select('states.state', 'states.state_id')->where('states.country_id', '=', $country_id)->isDefault()->active()->sorted()->pluck('states.state', 'states.state_id')->toArray();
        return $array;
    }

    /*     * **************************** */

    public static function defaultCitiesArray($state_id)
    {
        $array = City::select('cities.city', 'cities.city_id')->where('cities.state_id', '=', $state_id)->isDefault()->active()->sorted()->pluck('cities.city', 'cities.city_id')->toArray();
        return $array;
    }

    /*     * **************************** */

    public static function langStatesArray($country_id)
    {
        $array = State::select('states.state', 'states.state_id')->where('states.country_id', '=', $country_id)->lang()->active()->sorted()->pluck('states.state', 'states.state_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultStatesArray($country_id);
        }
        return $array;
    }

    /*     * **************************** */

    public static function langCitiesArray($state_id)
    {
        $array = City::select('cities.city', 'cities.city_id')->where('cities.state_id', '=', $state_id)->lang()->active()->sorted()->pluck('cities.city', 'cities.city_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultCitiesArray($state_id);
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultDegreeTypesArray($degree_level_id)
    {
        $array = DegreeType::select('degree_types.degree_type', 'degree_types.degree_type_id')->where('degree_level_id', '=', $degree_level_id)->isDefault()->active()->sorted()->pluck('degree_types.degree_type', 'degree_types.degree_type_id')->toArray();
        return $array;
    }

    public static function langDegreeTypesArray($degree_level_id)
    {
        $array = DegreeType::select('degree_types.degree_type', 'degree_types.degree_type_id')->where('degree_level_id', '=', $degree_level_id)->lang()->active()->sorted()->pluck('degree_types.degree_type', 'degree_types.degree_type_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultDegreeTypesArray($degree_level_id);
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultGendersArray()
    {
        $array = Gender::select('genders.gender', 'genders.gender_id')->isDefault()->active()->sorted()->pluck('genders.gender', 'genders.gender_id')->toArray();
        return $array;
    }

    public static function langGendersArray()
    {
        $array = Gender::select('genders.gender', 'genders.gender_id')->lang()->active()->sorted()->pluck('genders.gender', 'genders.gender_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultGendersArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultMaritalStatusesArray()
    {
        $array = MaritalStatus::select('marital_statuses.marital_status', 'marital_statuses.marital_status_id')->isDefault()->active()->sorted()->pluck('marital_statuses.marital_status', 'marital_statuses.marital_status_id')->toArray();
        return $array;
    }

    public static function langMaritalStatusesArray()
    {
        $array = MaritalStatus::select('marital_statuses.marital_status', 'marital_statuses.marital_status_id')->lang()->active()->sorted()->pluck('marital_statuses.marital_status', 'marital_statuses.marital_status_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultMaritalStatusesArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultNationalitiesArray()
    {
        $array = Country::select('countries.nationality', 'countries.country_id')->isDefault()->active()->sorted()->pluck('countries.nationality', 'countries.country_id')->toArray();
        return $array;
    }

    public static function langNationalitiesArray()
    {
        $array = Country::select('countries.nationality', 'countries.country_id')->lang()->active()->sorted()->pluck('countries.nationality', 'countries.country_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultNationalitiesArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultCountriesArray()
    {
        $array = Country::select('countries.country', 'countries.country_id')->isDefault()->active()->sorted()->pluck('countries.country', 'countries.country_id')->toArray();
        return $array;
    }

    public static function langCountriesArray()
    {
        $array = Country::select('countries.country', 'countries.country_id')->lang()->active()->sorted()->pluck('countries.country', 'countries.country_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultCountriesArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultCareerLevelsArray()
    {
        $array = CareerLevel::select('career_levels.career_level', 'career_levels.career_level_id')->isDefault()->active()->sorted()->pluck('career_levels.career_level', 'career_levels.career_level_id')->toArray();
        return $array;
    }

    public static function langCareerLevelsArray()
    {
        $array = CareerLevel::select('career_levels.career_level', 'career_levels.career_level_id')->lang()->active()->sorted()->pluck('career_levels.career_level', 'career_levels.career_level_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultCareerLevelsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultIndustriesArray()
    {
        $array = Industry::select('industries.industry', 'industries.industry_id')->isDefault()->active()->sorted()->pluck('industries.industry', 'industries.industry_id')->toArray();
        return $array;
    }

    public static function langIndustriesArray()
    {
        $array = Industry::select('industries.industry', 'industries.industry_id')->lang()->active()->sorted()->pluck('industries.industry', 'industries.industry_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultIndustriesArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultFunctionalAreasArray()
    {
        $array = FunctionalArea::select('functional_areas.functional_area', 'functional_areas.functional_area_id')->isDefault()->active()->sorted()->pluck('functional_areas.functional_area', 'functional_areas.functional_area_id')->toArray();
        return $array;
    }

    public static function langFunctionalAreasArray()
    {
        $array = FunctionalArea::select('functional_areas.functional_area', 'functional_areas.functional_area_id')->lang()->active()->sorted()->pluck('functional_areas.functional_area', 'functional_areas.functional_area_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultFunctionalAreasArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultDegreelevelsArray()
    {
        $array = DegreeLevel::select('degree_levels.degree_level', 'degree_levels.degree_level_id')->isDefault()->active()->sorted()->pluck('degree_levels.degree_level', 'degree_levels.degree_level_id')->toArray();
        return $array;
    }

    public static function langDegreelevelsArray()
    {
        $array = DegreeLevel::select('degree_levels.degree_level', 'degree_levels.degree_level_id')->lang()->active()->sorted()->pluck('degree_levels.degree_level', 'degree_levels.degree_level_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultDegreelevelsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultResultTypesArray()
    {
        $array = ResultType::select('result_types.result_type', 'result_types.result_type_id')->isDefault()->active()->sorted()->pluck('result_types.result_type', 'result_types.result_type_id')->toArray();
        return $array;
    }

    public static function langResultTypesArray()
    {
        $array = ResultType::select('result_types.result_type', 'result_types.result_type_id')->lang()->active()->sorted()->pluck('result_types.result_type', 'result_types.result_type_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultResultTypesArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultMajorSubjectsArray()
    {
        $array = MajorSubject::select('major_subjects.major_subject', 'major_subjects.major_subject_id')->isDefault()->active()->sorted()->pluck('major_subjects.major_subject', 'major_subjects.major_subject_id')->toArray();
        return $array;
    }

    public static function langMajorSubjectsArray()
    {
        $array = MajorSubject::select('major_subjects.major_subject', 'major_subjects.major_subject_id')->lang()->active()->sorted()->pluck('major_subjects.major_subject', 'major_subjects.major_subject_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultMajorSubjectsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function languagesArray()
    {
        $array = Language::select('languages.lang', 'languages.id')->pluck('languages.lang', 'languages.id')->toArray();
        return $array;
    }

    public static function languagesNativeCodeArray()
    {
        $array = Language::select('languages.native', 'languages.iso_code')->active()->sorted()->pluck('languages.native', 'languages.iso_code')->toArray();
        return $array;
    }

    /*     * **************************** */

    public static function defaultLanguageLevelsArray()
    {
        $array = LanguageLevel::select('language_levels.language_level', 'language_levels.language_level_id')->isDefault()->active()->sorted()->pluck('language_levels.language_level', 'language_levels.language_level_id')->toArray();
        return $array;
    }

    public static function langLanguageLevelsArray()
    {
        $array = LanguageLevel::select('language_levels.language_level', 'language_levels.language_level_id')->lang()->active()->sorted()->pluck('language_levels.language_level', 'language_levels.language_level_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultLanguageLevelsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultJobSkillsArray()
    {
        $array = JobSkill::select('job_skills.job_skill', 'job_skills.job_skill_id')->isDefault()->active()->sorted()->pluck('job_skills.job_skill', 'job_skills.job_skill_id')->toArray();
        return $array;
    }

    public static function langJobSkillsArray()
    {
        $array = JobSkill::select('job_skills.job_skill', 'job_skills.job_skill_id')->lang()->active()->sorted()->pluck('job_skills.job_skill', 'job_skills.job_skill_id')->toArray();

        if ((int) count($array) === 0) {
            $array = self::defaultJobSkillsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultJobExperiencesArray()
    {
        $array = JobExperience::select('job_experiences.job_experience', 'job_experiences.job_experience_id')->isDefault()->active()->sorted()->pluck('job_experiences.job_experience', 'job_experiences.job_experience_id')->toArray();
        return $array;
    }

    public static function langJobExperiencesArray()
    {
        $array = JobExperience::select('job_experiences.job_experience', 'job_experiences.job_experience_id')->lang()->active()->sorted()->pluck('job_experiences.job_experience', 'job_experiences.job_experience_id')->toArray();

        if ((int) count($array) === 0) {
            $array = self::defaultJobExperiencesArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultJobTypesArray()
    {
        $array = JobType::select('job_types.job_type', 'job_types.job_type_id')->isDefault()->active()->sorted()->pluck('job_types.job_type', 'job_types.job_type_id')->toArray();
        return $array;
    }

    public static function langJobTypesArray()
    {
        $array = JobType::select('job_types.job_type', 'job_types.job_type_id')->lang()->active()->sorted()->pluck('job_types.job_type', 'job_types.job_type_id')->toArray();

        if ((int) count($array) === 0) {
            $array = self::defaultJobTypesArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultJobShiftsArray()
    {
        $array = JobShift::select('job_shifts.job_shift', 'job_shifts.job_shift_id')->isDefault()->active()->sorted()->pluck('job_shifts.job_shift', 'job_shifts.job_shift_id')->toArray();
        return $array;
    }

    public static function langJobShiftsArray()
    {
        $array = JobShift::select('job_shifts.job_shift', 'job_shifts.job_shift_id')->lang()->active()->sorted()->pluck('job_shifts.job_shift', 'job_shifts.job_shift_id')->toArray();

        if ((int) count($array) === 0) {
            $array = self::defaultJobShiftsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function currenciesArray()
    {
        $array = CountryDetail::select('countries_details.code')->whereNotNull('countries_details.code')->orderBy('countries_details.code')->pluck('countries_details.code', 'countries_details.code')->toArray();
        return $array;
    }

    /*     * **************************** */

    public static function companiesArray()
    {
        $array = Company::select('companies.name', 'companies.id')->active()->pluck('companies.name', 'companies.id')->toArray();
        return $array;
    }

    /*     * **************************** */

    public static function usersArray()
    {
        $array = User::select('users.id', 'users.name')->orderBy('users.name')->pluck('users.name', 'users.id')->toArray();
        return $array;
    }

    /*     * **************************** */

    public static function defaultJobTitlesArray()
    {
        $array = JobTitle::select('job_titles.job_title', 'job_titles.job_title_id')->isDefault()->sorted()->pluck('job_titles.job_title', 'job_titles.job_title_id')->toArray();
        return $array;
    }

    public static function langJobTitlesArray()
    {
        $array = JobTitle::select('job_titles.job_title', 'job_titles.job_title_id')->lang()->sorted()->pluck('job_titles.job_title', 'job_titles.job_title_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultJobTitlesArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultOwnershipTypesArray()
    {
        $array = OwnershipType::select('ownership_types.ownership_type', 'ownership_types.ownership_type_id')->isDefault()->active()->sorted()->pluck('ownership_types.ownership_type', 'ownership_types.ownership_type_id')->toArray();
        return $array;
    }

    public static function langOwnershipTypesArray()
    {
        $array = OwnershipType::select('ownership_types.ownership_type', 'ownership_types.ownership_type_id')->lang()->active()->sorted()->pluck('ownership_types.ownership_type', 'ownership_types.ownership_type_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultOwnershipTypesArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultSalaryPeriodsArray()
    {
        $array = SalaryPeriod::select('salary_periods.salary_period', 'salary_periods.salary_period_id')->isDefault()->active()->sorted()->pluck('salary_periods.salary_period', 'salary_periods.salary_period_id')->toArray();
        return $array;
    }

    public static function langSalaryPeriodsArray()
    {
        $array = SalaryPeriod::select('salary_periods.salary_period', 'salary_periods.salary_period_id')->lang()->active()->sorted()->pluck('salary_periods.salary_period', 'salary_periods.salary_period_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultSalaryPeriodsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultVideosArray()
    {
        $array = Video::select('videos.video_title', 'videos.video_id')->isDefault()->active()->sorted()->pluck('videos.video_title', 'videos.video_id')->toArray();
        return $array;
    }

    public static function langVideosArray()
    {
        $array = Video::select('videos.video_title', 'videos.video_id')->lang()->active()->sorted()->pluck('videos.video_title', 'videos.video_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultVideosArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultTestimonialsArray()
    {
        $array = Testimonial::select('testimonials.testimonial_by', 'testimonials.testimonial_id')->isDefault()->active()->sorted()->pluck('testimonials.testimonial_by', 'testimonials.testimonial_id')->toArray();
        return $array;
    }

    public static function langTestimonialsArray()
    {
        $array = Testimonial::select('testimonials.testimonial_by', 'testimonials.testimonial_id')->lang()->active()->sorted()->pluck('testimonials.testimonial_by', 'testimonials.testimonial_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultTestimonialsArray();
        }
        return $array;
    }

    /*     * **************************** */

    public static function defaultSlidersArray()
    {
        $array = Slider::select('sliders.slider_heading', 'sliders.slider_id')->isDefault()->active()->sorted()->pluck('sliders.slider_heading', 'sliders.slider_id')->toArray();
        return $array;
    }

    public static function langSlidersArray()
    {
        $array = Slider::select('sliders.slider_heading', 'sliders.slider_id')->lang()->active()->sorted()->pluck('sliders.slider_heading', 'sliders.slider_id')->toArray();
        if ((int) count($array) === 0) {
            $array = self::defaultSlidersArray();
        }
        return $array;
    }

    /*     * **************************** */
}
