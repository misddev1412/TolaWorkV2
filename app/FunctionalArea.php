<?php

namespace App;

use App;
use App\Traits\Lang;
use App\Traits\IsDefault;
use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class FunctionalArea extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;

    protected $table = 'functional_areas';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public static function getUsingFunctionalAreas($limit = 10)
    {
        $functionalAreaIds = App\Job::select('functional_area_id')->pluck('functional_area_id')->toArray();
        return App\FunctionalArea::whereIn('functional_area_id', $functionalAreaIds)->lang()->active()->inRandomOrder()->paginate($limit);
    }

}
