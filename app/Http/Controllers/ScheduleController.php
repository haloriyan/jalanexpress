<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public static function get($filter = NULL) {
        if ($filter == NULL) {
            return new Schedule;
        }
        return Schedule::where($filter);
    }
    public function store(Request $request) {
        $saveData = Schedule::create([
            'time' => $request->time,
            'price' => $request->price,
            'region' => $request->region,
            'max_orders' => $request->max_orders,
        ]);

        return redirect()->route('admin.schedule')->with(['message' => "New schedule has been added"]);
    }
    public function update(Request $request) {
        $id = $request->id;
        $updateData = Schedule::where('id', $id)->update([
            'time' => $request->time,
            'price' => $request->price,
            'region' => $request->region,
            'max_orders' => $request->max_orders,
        ]);

        return redirect()->route('admin.schedule')->with(['message' => "Schedule data has been updated"]);
    }
}
