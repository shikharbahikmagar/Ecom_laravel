<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    use HasFactory;
    public static function getShippingCharge($country)
    {
        $shipping_details = ShippingCharge::where('country', $country)->first()->toArray();
        $shipping_charge = $shipping_details['shipping_charges'];
        return $shipping_charge;
    }
}
