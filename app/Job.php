<?php

namespace App;

use DB;
use App;
use App\Traits\Active;
use App\Traits\Featured;
use App\Traits\JobTrait;
use App\Traits\CountryStateCity;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    use Active;
    use featured;
    use JobTrait;
    use CountryStateCity;

    protected $table = 'jobs';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at', 'expiry_date'];

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id', 'id');
    }

    public function getCompany($field = '')
    {
        if (null !== $company = $this->company()->first()) {
            if (!empty($field)) {
                return $company->$field;
            } else {
                return $company;
            }
        }
    }

    public function jobSkills()
    {
        return $this->hasMany('App\JobSkillManager', 'job_id', 'id');
    }

    public function getJobSkillsArray()
    {
        return $this->jobSkills->pluck('job_skill_id')->toArray();
    }

    public function getJobSkillsStr()
    {
        $str = '';
        if ($this->jobSkills->count()) {
            $jobSkills = $this->jobSkills;
            foreach ($jobSkills as $jobSkillManager) {
                $str .= ' ' . $jobSkillManager->getJobSkill('job_skill');
            }
        }
        return $str;
    }

    public function getJobSkillsList()
    {
        $str = '';
        if ($this->jobSkills->count()) {
            $jobSkills = $this->jobSkills;
            foreach ($jobSkills as $jobSkillManager) {
                $skill = $jobSkillManager->getJobSkill();
                $str .= '<li><a href="' . route('job.list', ['job_skill_id[]' => $skill->job_skill_id]) . '">' . $skill->job_skill . '</a></li>';
            }
        }
        return $str;
    }

    public function careerLevel()
    {
        return $this->belongsTo('App\CareerLevel', 'career_level_id', 'career_level_id');
    }

    public function getCareerLevel($field = '')
    {
        $careerLevel = $this->careerLevel()->lang()->first();
        if (null === $careerLevel) {
            $careerLevel = $this->careerLevel()->first();
        }
        if (null !== $careerLevel) {
            if (!empty($field)) {
                return $careerLevel->$field;
            } else {
                return $careerLevel;
            }
        }
    }

    public function functionalArea()
    {
        return $this->belongsTo('App\FunctionalArea', 'functional_area_id', 'functional_area_id');
    }

    public function getFunctionalArea($field = '')
    {
        $functionalArea = $this->functionalArea()->lang()->first();
        if (null === $functionalArea) {
            $functionalArea = $this->functionalArea()->first();
        }
        if (null !== $functionalArea) {
            if (!empty($field)) {
                return $functionalArea->$field;
            } else {
                return $functionalArea;
            }
        }
    }

    public function jobType()
    {
        return $this->belongsTo('App\JobType', 'job_type_id', 'job_type_id');
    }

    public function getJobType($field = '')
    {
        $jobType = $this->jobType()->lang()->first();
        if (null === $jobType) {
            $jobType = $this->jobType()->first();
        }
        if (null !== $jobType) {
            if (!empty($field)) {
                return $jobType->$field;
            } else {
                return $jobType;
            }
        }
    }

    public function jobShift()
    {
        return $this->belongsTo('App\JobShift', 'job_shift_id', 'job_shift_id');
    }

    public function getJobShift($field = '')
    {
        $jobShift = $this->jobShift()->lang()->first();
        if (null === $jobShift) {
            $jobShift = $this->jobShift()->first();
        }
        if (null !== $jobShift) {
            if (!empty($field)) {
                return $jobShift->$field;
            } else {
                return $jobShift;
            }
        }
    }

    public function salaryPeriod()
    {
        return $this->belongsTo('App\SalaryPeriod', 'salary_period_id', 'salary_period_id');
    }

    public function getSalaryPeriod($field = '')
    {
        $salaryPeriod = $this->salaryPeriod()->lang()->first();
        if (null === $salaryPeriod) {
            $salaryPeriod = $this->salaryPeriod()->first();
        }
        if (null !== $salaryPeriod) {
            if (!empty($field)) {
                return $salaryPeriod->$field;
            } else {
                return $salaryPeriod;
            }
        }
    }

    public function gender()
    {
        return $this->belongsTo('App\Gender', 'gender_id', 'gender_id');
    }

    public function getGender($field = '')
    {
        $gender = $this->gender()->lang()->first();
        if (null === $gender) {
            $gender = $this->gender()->first();
        }
        if (null !== $gender) {
            if (!empty($field)) {
                return $gender->$field;
            } else {
                return $gender;
            }
        } else {
            return __('No Preference');
        }
    }

    public function degreeLevel()
    {
        return $this->belongsTo('App\DegreeLevel', 'degree_level_id', 'degree_level_id');
    }

    public function getDegreeLevel($field = '')
    {
        $degreeLevel = $this->degreeLevel()->lang()->first();
        if (null === $degreeLevel) {
            $degreeLevel = $this->degreeLevel()->first();
        }
        if (null !== $degreeLevel) {
            if (!empty($field)) {
                return $degreeLevel->$field;
            } else {
                return $degreeLevel;
            }
        }
    }

    public function jobExperience()
    {
        return $this->belongsTo('App\JobExperience', 'job_experience_id', 'job_experience_id');
    }

    public function getJobExperience($field = '')
    {
        $jobExperience = $this->jobExperience()->lang()->first();
        if (null === $jobExperience) {
            $jobExperience = $this->jobExperience()->first();
        }
        if (null !== $jobExperience) {
            if (!empty($field)) {
                return $jobExperience->$field;
            } else {
                return $jobExperience;
            }
        }
    }

    /*     * ****************************** */

    public function appliedUsers()
    {
        return $this->hasMany('App\JobApply', 'job_id', 'id');
    }

    public function getAppliedUserIdsArray()
    {
        return $this->appliedUsers->pluck('user_id')->toArray();
    }

    /*     * ***************************** */
}
