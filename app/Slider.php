<?php

namespace App;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;

    protected $table = 'sliders';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];
	
	public static function defaultSliders()
    {
        $array = Slider::isDefault()->active()->sorted()->get();
        return $array;
    }

    public static function langSliders()
    {
        $array = Slider::lang()->active()->sorted()->get();
        if ((int) count($array) === 0) {
            $array = self::defaultSliders();
        }
        return $array;
    }
}
