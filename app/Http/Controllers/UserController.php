<?php

namespace App\Http\Controllers;

use Str;
use App\Models\Shipment;
use App\Models\ShipmentReceiver;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return view('index');
    }
    public function check() {
        return view('check');
    }
    public function about() {
        return view('about');
    }
    public function pricing() {
        $schedulesRaw = ScheduleController::get()->orderBy('region', 'ASC')->get();
        $schedules = [];

        foreach ($schedulesRaw as $schedule) {
            if (! array_key_exists($schedule->region, $schedules)) {
                $schedules[$schedule->region] = [
                    'price' => $schedule->price,
                    'times' => []
                ];
            }

            if (array_key_exists($schedule->region, $schedules)) {
                array_push($schedules[$schedule->region]['times'], $schedule->time);
            }
        }

        return view('pricing', [
            'schedules' => $schedules
        ]);
    }
    public function send() {
        $schedules = ScheduleController::get()->orderBy('region', 'ASC')->get();
        return view('send', [
            'schedules' => $schedules
        ]);
    }
    public function sending(Request $request) {
        $receiver_name = $request->receiver_name;
        $receiver_phone = $request->receiver_phone;
        $receiver_region = $request->receiver_region;
        $receiver_address = $request->receiver_address;
        $weight = $request->weight;
        $dimension = $request->dimension;
        $notes = $request->notes;

        $pickupTime = $request->pickup_time;
        $totalPay = 0;
        $totalWeight = 0;
        $items = [];
        $photo = $request->file('photos');

        $shippingCode = "JE_".strtoupper(Str::random(8));

        foreach ($receiver_name as $i => $name) {
            $schedule = ScheduleController::get([
                ['time', $pickupTime],
                ['region', $receiver_region[$i]]
            ])->first();
            $totalPay += $schedule->price;
            $totalWeight += $weight[$i];

            $items[] = [
                'receiver_name' => $receiver_name[$i],
                'receiver_phone' => $receiver_phone[$i],
                'receiver_region' => $receiver_region[$i],
                'receiver_address' => $receiver_address[$i],
                'weight' => $weight[$i],
                'dimension' => $dimension[$i],
                'status' => 0,
                'notes' => $notes[$i],
            ];

            if (isset($photo[$i])) {
                $photoFileName = $photo[$i]->getClientOriginalName();
                $items[$i]['photo'] = $photoFileName;
                $photo[$i]->storeAs('public/foto_barang', $photoFileName);
            }
        }

        $saveSender = Shipment::create([
            'shipping_code' => $shippingCode,
            'sender_name' => $request->sender_name,
            'sender_phone' => $request->sender_phone,
            'sender_region' => $request->sender_region,
            'sender_address' => $request->sender_address,
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            'total_pay' => $totalPay,
            'total_weight' => $totalWeight,
            'status' => 0
        ]);

        foreach ($items as $i => $item) {
            $item['shipment_id'] = $saveSender->id;
            $saveReceiver = ShipmentReceiver::create($item);
        }

        return redirect()->route('user.pay', ['inv' => $shippingCode]);
    }
    public function done(Request $request) {
        return view('done', ['request' => $request]);
    }
    public function pay(Request $request) {
        return view('pay', ['request' => $request]);
    }
    public function track(Request $request) {
        $code = $request->code;

        $data = ShipmentController::get([['shipping_code', $code]])
        ->with(['receivers','courier'])->first();

        return response()->json([
            'data' => $data,
            'code' => $code,
            'message' => "OK"
        ]);
    }
}
