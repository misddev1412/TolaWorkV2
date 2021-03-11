<?php

namespace App\Traits;

use View;
use App\Seo;

trait ShareToLayout
{

    public function shareSeoToLayout($page)
    {
        return View::composer('layouts.app', function($view) use ($page) {
                    $seo = SEO::where('seo.page_title', 'like', $page)->get();
                    $view->with('seo', $seo);
                });
    }

}
