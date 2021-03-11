<?php

namespace App;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class DegreeType extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;

    protected $table = 'degree_types';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

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
            if (!empty($field))
                return $degreeLevel->$field;
            else
                return $degreeLevel;
        }
    }

}
