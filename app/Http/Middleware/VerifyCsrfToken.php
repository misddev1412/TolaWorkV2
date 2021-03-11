<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'tinymce-image_upload-front',
        'admin/tinymce-image_upload',
        'upload-project-temp-image',
        'upload-front-project-temp-image',
    ];

}
