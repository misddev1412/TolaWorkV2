<?php

namespace App\Providers;

use DB;
use View;
use App\Language;
use App\SiteSetting;
use App\Cms;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $siteLanguages = Language::where('is_active', '=', 1)->get();
        $siteSetting = SiteSetting::findOrFail(1272);
        $show_in_top_menu = Cms::where('show_in_top_menu', 1)->get();
        $show_in_footer_menu = Cms::where('show_in_footer_menu', 1)->get();
        /*         * *********************************** */
        View::share(
                [
                    'siteLanguages' => $siteLanguages,
                    'siteSetting' => $siteSetting,
                    'show_in_top_menu' => $show_in_top_menu,
                    'show_in_footer_menu' => $show_in_footer_menu
                ]
        );
    }

    public function register()
    {
        //
    }

}
