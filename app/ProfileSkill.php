<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileSkill extends Model
{

    protected $table = 'profile_skills';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function getUser($field = '')
    {
        if (null !== $user = $this->user()->first()) {
            if (empty($field))
                return $user;
            else
                return $user->$field;
        } else {
            return '';
        }
    }

    public function jobSkill()
    {
        return $this->belongsTo('App\JobSkill', 'job_skill_id', 'job_skill_id');
    }

    public function getJobSkill($field = '')
    {
        $jobSkill = $this->jobSkill()->lang()->first();
        if (null === $jobSkill) {
            $jobSkill = $this->jobSkill()->first();
        }
        if (null !== $jobSkill) {
            if (empty($field))
                return $jobSkill;
            else
                return $jobSkill->$field;
        } else {
            return '';
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
            if (empty($field))
                return $jobExperience;
            else
                return $jobExperience->$field;
        } else {
            return '';
        }
    }

}
