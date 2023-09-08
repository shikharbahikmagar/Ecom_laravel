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
        "/admin/check-current-pwd", "/admin/update-section-status", "/admin/update-category-status", 
        "/admin/append-categories-level", "/admin/update-product-status", "/admin/update-attribute-status", 
        "/admin/update-product-image-status", "/admin/update-brand-status", "/admin/update-banner-status", 
        "/getting-product-price", "/update-cart-item-qty", "/admin/update-coupon-status", "/admin/update-shipping-status",
    ];
}
