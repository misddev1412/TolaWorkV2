<?php

namespace App;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;

    protected $table = 'testimonials';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public static function defaultTestimonials()
    {
        $array = Testimonial::isDefault()->active()->sorted()->get();
        return $array;
    }

    public static function langTestimonials()
    {
        $array = Testimonial::lang()->active()->sorted()->get();
        if ((int) count($array) === 0) {
            $array = self::defaultTestimonials();
        }
        return $array;
    }

}
