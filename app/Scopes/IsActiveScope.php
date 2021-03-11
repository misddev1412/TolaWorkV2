<?php

namespace App\Scopes;

use Auth;
use App;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class IsActiveScope implements Scope
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (
                Auth::check() &&
                (
                Auth::user()->getAdminUserRole()->role_abbreviation == 'SUP_ADM' ||
                (Auth::user()->getAdminUserRole()->role_abbreviation == 'SUB_ADM')
                )
        ) {
            return;
        } else {
            $builder->where('is_active', '=', '1');
        }
    }

}
