<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdminFormErrorHelper
{

    public static function hasError($errors, $field)
    {
        return ($errors->first($field) != '') ? 'has-error msg_cls_for_focus' : '';
    }

    public static function showErrors($errors, $field)
    {
        $html = '';
        if ($errors->first($field) != ''):
            foreach ($errors->get($field) as $message):
                $html .= '<span id="name-error" class="help-block help-block-error">' . $message . '</span>';
            endforeach;
        endif;
        return $html;
    }

    public static function showErrorsNotice($errors)
    {
        $html = '';
        if (count($errors) > 0) {
            $html .= '<div class="alert alert-danger">You have some form errors. Please check below.<ul>';
            foreach ($errors->all() as $message):
                $html .= '<li><span id="name-error" class="help-block help-block-error">' . $message . '</span></li>';
            endforeach;
            $html .= '</ul></div>';
        }
        return $html;
    }

    public static function showOnlyErrorsNotice($errors)
    {
        $html = '';
        if (count($errors) > 0) {
            $html = '<div class="alert alert-danger">You have some form errors. Please check below.</div>';
        }
        return $html;
    }

}
