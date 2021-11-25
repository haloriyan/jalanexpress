<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipping_code','sender_name','sender_phone','sender_region','sender_address',
        'pickup_date','pickup_time','pickup_photo','status','total_pay','total_weight'
    ];

    public function receivers() {
        return $this->hasMany('App\Models\ShipmentReceiver', 'shipment_id');
    }
    public function courier() {
        return $this->belongsTo('App\Models\Courier', 'courier_id');
    }
}
