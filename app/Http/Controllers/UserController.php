<?php

namespace App\Http\Controllers;

use Str;
use Carbon\Carbon;
use App\Models\Shipment;
use App\Models\ShipmentReceiver;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return view('index');
    }
    public function check(Request $request) {
        return view('check', ['request' => $request]);
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
        Carbon::setLocale('id');
        $receiver_name = $request->receiver_name;
        $receiver_phone = $request->receiver_phone;
        $receiver_region = $request->receiver_region;
        $receiver_address = $request->receiver_address;
        $weight = $request->weight;
        $dimension = $request->dimension;
        $notes = $request->notes;

        $pickupTime = Carbon::parse($request->pickup_time)->format('H:i');
        $pickupDate = Carbon::parse($request->pickup_date)->isoFormat('DD MMMM YYYY');
        $totalPay = 0;
        $totalWeight = 0;
        $items = [];
        $photo = $request->file('photos');
        $ongkirs = explode(",", $request->ongkirs);

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
                'ongkir' => $ongkirs[$i],
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

        $senderPhone = $request->sender_phone;
        if ($senderPhone[0] == "0") {
            $senderPhone = preg_replace('/^0?/', "62", $senderPhone);
        }
        $senderMessage = "Halo, ".$request->sender_name.PHP_EOL.PHP_EOL;
        $senderMessage .= "Kiriman Anda telah kami terima dan tercatat di sistem JalanExpress. Kurir kami akan segera mengabari Anda mengenai pengiriman ini".PHP_EOL.PHP_EOL;
        $senderMessage .= "Untuk informasi lebih detail mengenai kiriman Anda, dapat dilihat di".PHP_EOL.PHP_EOL;
        $senderMessage .= route('user.check', ['code' => $shippingCode]).PHP_EOL.PHP_EOL;
        $senderMessage .= "Terima kasih telah mempercayakan kiriman Anda kepada JalanExpress. Follow instagram @jalanexpress untuk mendapatkan informasi promo jalan-jalan untuk barang Anda";

        foreach ($items as $i => $item) {
            $item['shipment_id'] = $saveSender->id;
            $receiverMessage = "Halo, ".$receiver_name[$i].PHP_EOL.PHP_EOL;
            $receiverMessage .= "Kiriman Anda dari ".$request->sender_name." telah diinputkan melalui jalanexpress dan akan diantarkan pada ".$pickupDate." menuju ".$receiver_address[$i].PHP_EOL.PHP_EOL;
            $receiverMessage .= "Untuk mengecek status pengiriman dapat dilihat di ".route('user.check', ['code' => $shippingCode]);
            
            $receiverPhone = $receiver_phone[$i];
            if ($receiverPhone[0] == "0") {
                $receiverPhone = preg_replace('/^0?/', "62", $receiverPhone);
            }

            NotifyController::send($receiverPhone, $receiverMessage);
            $saveReceiver = ShipmentReceiver::create($item);
        }

        // Notify All Courier
        $couriers = CourierController::get()->get();
        foreach ($couriers as $courier) {
            $courierPhone = $courier->phone;
            if ($courierPhone[0] == "0") {
                $courierPhone = preg_replace('/^0?/', "62", $courierPhone);
            }
            
            $courierMessage = "Ada kiriman di JalanExpress nih, $courier->name.".PHP_EOL.PHP_EOL;
            $courierMessage .= "$request->sender_name ingin mengirim paket dari $request->sender_region ke ".count($items)." penerima pada $pickupDate jam $pickupTime.".PHP_EOL.PHP_EOL;
            $courierMessage .= "Area : $request->sender_region".PHP_EOL;
            $courierMessage .= "Tanggal : $pickupDate ($pickupTime)".PHP_EOL;
            $courierMessage .= "Berat Total : $totalWeight kg".PHP_EOL.PHP_EOL;
            $courierMessage .= "Jika bersedia silahkan login ke website dan segera ambil kiriman sebelum diambil kurir lainnya".PHP_EOL.PHP_EOL;
            $courierMessage .= route('courier.find.detail', $saveSender->id);

            $notifyCourier = NotifyController::send($courierPhone, $courierMessage);
        }

        return redirect()->route('user.done', ['code' => $shippingCode]);
    }
    public function done(Request $request) {
        $shipment = ShipmentController::get([['shipping_code', $request->code]])->with('receivers')->first();
        if ($request->code == "" || $shipment == "") {
            return redirect()->route('user.index');
        }

        return view('done', [
            'request' => $request,
            'shipment' => $shipment
        ]);
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
    public function term() {
        return view('term');
    }
    public function faq() {
        $faqs = FaqController::get()->orderBy('created_at', 'DESC')->get();
        return view('faq', [
            'faqs' => $faqs
        ]);
    }
}
