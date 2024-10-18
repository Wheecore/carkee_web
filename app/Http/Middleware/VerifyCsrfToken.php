<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
     protected $except = [
         '/config_content',
         '/mock_payments',
         '/ipay88/response',
         '/ipay88/backend',
         '/api/v2/api/ipay88/emergency-response',
         '/api/v2/api/ipay88/emergency-backend',
         '/admin/get-all-tyres',
         '/admin/get-all-batteries',
         '/admin/get-all-services',
         '/contact-form-submit',
         'ipay-webview',
         'ipay-webview-payment'
     ];
}
