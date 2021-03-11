<?php

namespace App;

use App;
use Illuminate\Database\Eloquent\Model;

class JobSkillManager extends Model
{

    protected $table = 'manage_job_skills';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function job()
    {
        return $this->belongsTo('App\Job', 'job_id', 'id');
    }

    public function getJob($field = '')
    {
        if (null !== $job = $this->job()->first()) {
            if (!empty($field)) {
                return $job->$field;
            } else {
                return $job;
            }
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
            if (!empty($field)) {
                return $jobSkill->$field;
            } else {
                return $jobSkill;
            }
        }
    }

}
