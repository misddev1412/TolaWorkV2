<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileEducationMajorSubject extends Model
{

    protected $table = 'profile_education_major_subjects';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function profileEducation()
    {
        return $this->belongsTo('App\ProfileEducation', 'profile_education_id', 'id');
    }

    public function getProfileEducation($field = '')
    {
        if (null !== $profileEducation = $this->profileEducation()->first()) {
            if (empty($field))
                return $profileEducation;
            else
                return $profileEducation->$field;
        } else {
            return '';
        }
    }

    public function majorSubject()
    {
        return $this->belongsTo('App\MajorSubject', 'major_subject_id', 'major_subject_id');
    }

    public function getMajorSubject($field = '')
    {
        if (null !== $majorSubject = $this->majorSubject()->first()) {
            if (empty($field))
                return $majorSubject;
            else
                return $majorSubject->$field;
        } else {
            return '';
        }
    }

}
