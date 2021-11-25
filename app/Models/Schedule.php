<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'price','time','region','max_orders'
    ];

    public function detail() {
        return $this->hasMany('App\Models\CourierSchedule', 'schedule_id');
    }
}
