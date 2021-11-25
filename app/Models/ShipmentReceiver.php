<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentReceiver extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id','receiver_name','receiver_phone','receiver_region','receiver_address',
        'weight','dimension','photo','notes','status'
    ];

    public function shipment() {
        return $this->belongsTo('App\Models\Shipment', 'shipment_id');
    }
}
