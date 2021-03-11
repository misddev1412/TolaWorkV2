<?php



namespace App;



use DB;

use App;

use Illuminate\Database\Eloquent\Model;



class JobApply extends Model

{



    protected $table = 'job_apply';

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

            if (!empty($field)) {

                return $user->$field;

            } else {

                return $user;

            }

        }

    }



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



    public function profileCv()

    {

        return $this->belongsTo('App\ProfileCv', 'cv_id', 'id');

    }



    public function getProfileCv($field = '')

    {

        if (null !== $profileCv = $this->profileCv()->first()) {

            if (!empty($field)) {

                return $profileCv->$field;

            } else {

                return $profileCv;

            }

        }

    }



}

