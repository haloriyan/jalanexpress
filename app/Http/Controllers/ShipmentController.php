<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public static function get($filter = NULL) {
        if ($filter == NULL) {
            return new Shipment;
        }
        return Shipment::where($filter);
    }
}
