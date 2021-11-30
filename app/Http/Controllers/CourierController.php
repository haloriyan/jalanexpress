<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use Storage;
use Carbon\Carbon;
use App\Models\Courier;
use App\Models\ShipmentReceiver as Receiver;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    public static function me() {
        $myData = Auth::guard('courier')->user();
        return $myData;
    }
    public static function get($filter = NULL) {
        if ($filter == NULL) {
            return new Courier;
        }
        return Courier::where($filter);
    }
    public function store(Request $request) {
        $saveData = Courier::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.courier')->with(['message' => "New courier has been added"]);
    }
    public function update(Request $request) {
        $id = $request->id;
        $toUpdate = [
            'name' => $request->name,
            'phone' => $request->phone,
        ];
        if ($request->password != "") {
            $toUpdate['password'] = bcrypt($request->password);
        }

        $data = Courier::where('id', $id);
        $updateData = $data->update($toUpdate);

        return redirect()->route('admin.courier')->with(['message' => "Courier data has been updated"]);
    }
    public function loginPage() {
        $message = Session::get('message');
        return view('courier.login', ['message' => $message]);
    }
    public function login(Request $request) {
        $loggingIn = Auth::guard('courier')->attempt([
            'phone' => $request->phone,
            'password' => $request->password,
        ]);

        if (!$loggingIn) {
            return redirect()->route('courier.loginPage')->withErrors(['Kombinasi email dan password tidak tepat']);
        }

        return redirect()->route('courier.home');
    }
    public function logout() {
        $loggingOut = Auth::guard('courier')->logout();
        return redirect()->route('courier.loginPage');
    }
    public function home() {
        $myData = self::me();
        $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        $thisMonthJob = ShipmentController::get([
            ['courier_id', $myData->id],
            ['status', 1]
        ])
        ->whereBetween('pickup_date', [$startDate, $endDate])
        ->with('receivers')->get();

        $adminFee = 2000;
        foreach ($thisMonthJob as $job) {
            // $job->courier_income = $job->total_pay 
        }

        return view('courier.home', [
            'myData' => $myData,
            'thisMonthJob' => $thisMonthJob
        ]);
    }
    public function profile() {
        $myData = self::me();

        return view('courier.profile', [
            'myData' => $myData
        ]);
    }
    public function editProfile(Request $request) {
        $myData = self::me();
        if ($request->has('_token')) {
            $toUpdate = [
                'name' => $request->name,
            ];
            if ($request->has('photo')) {
                $photo = $request->file('photo');
                $photoFileName = $photo->getClientOriginalName();
                $toUpdate['photo'] = $photoFileName;
                if ($myData->photo != null) {
                    $deleteOldPhoto = Storage::delete('public/courier_photo/'.$myData->photo);
                }
                $photo->storeAs('public/courier_photo', $photoFileName);
            }
            if ($request->password != "") {
                $toUpdate['password'] = bcrypt($request->password);
                $loggingOut = Auth::guard('courier')->logout();
            }
            
            $updateData = Courier::where('id', $myData->id)->update($toUpdate);
            return redirect()->route('courier.profile.edit')->with(['message' => "Perubahan berhasil disimpan"]);
        } else {
            $message = Session::get('message');

            return view('courier.profile.edit', [
                'myData' => $myData,
                'message' => $message
            ]);
        }
    }
    public function find(Request $request) {
        $myData = self::me();
        $schedules = ScheduleController::get()->orderBy('region', 'ASC')->get();
        $dateNow = date('Y-m-d');
        $filters = [
            ['courier_id', NULL],
            ['pickup_date', '>=', $dateNow]
        ];

        if ($request->region != "") {
            array_push($filters, ['sender_region', $request->region]);
        }

        $jobs = ShipmentController::get($filters)->with('receivers')->get();

        return view('courier.find', [
            'myData' => $myData,
            'schedules' => $schedules,
            'request' => $request,
            'jobs' => $jobs
        ]);
    }
    public function findDetail($id) {
        $myData = self::me();
        $job = ShipmentController::get([['id', $id]])->first();

        return view('courier.detail', [
            'job' => $job,
            'myData' => $myData
        ]);
    }

    
    public function grabShipment($id) {
        $myData = self::me();
        Carbon::setLocale('id');
        
        $job = ShipmentController::get([['id', $id]]);
        $shipment = $job->with('receivers')->first();
        $pickupDate = Carbon::parse($shipment->pickup_date)->isoFormat('DD MMMM YYYY');
        $pickupTime = Carbon::parse($shipment->pickup_time)->format('H:i');

        // Notify Sender
        $senderPhone = $shipment->sender_phone;
        if ($senderPhone[0] == "0") {
            $senderPhone = preg_replace('/^0?/', "62", $senderPhone);
        }
        $senderMessage = "Halo, $shipment->sender_name".PHP_EOL.PHP_EOL;
        $senderMessage .= $myData->name." dari JalanExpress akan mengirimkan paket Anda. Pastikan semuanya telah siap untuk diambil pada $pickupDate";
        $notifySender = NotifyController::send($senderPhone, $senderMessage);
        
        // Notify Receivers
        foreach ($shipment->receivers as $receiver) {
            $receiverPhone = $receiver->receiver_phone;
            if ($receiverPhone[0] == "0") {
                $receiverPhone = preg_replace('/^0?/', "62", $receiverPhone);
            }
            
            $receiverMessage = "Halo, ".$receiver->receiver_name.PHP_EOL.PHP_EOL;
            $receiverMessage .= $myData->name." dari JalanExpress akan mengirimkan paket Anda dari $shipment->sender_name. Pastikan Anda berada di $receiver->receiver_address paling tidak 1 jam setelah pukul $shipment->pickup_time".PHP_EOL.PHP_EOL;
            $receiverMessage .= "Untuk informasi detail, Anda dapat melihatnya di ".PHP_EOL.PHP_EOL.route('user.check', ['code' => $shipment->shipping_code]);

            $notifySender = NotifyController::send($receiverPhone, $receiverMessage);
        }
        
        $job->update([
            'courier_id' => $myData->id
        ]);

        return redirect()->route('courier.job')->with(['message' => "Kiriman ini sekarang dapat Anda ambil dan antarkan"]);
    }
    public function job() {
        $myData = self::me();
        $message = Session::get('message');
        $dateNow = date('Y-m-d');

        $jobs = ShipmentController::get([
            ['courier_id', $myData->id],
            ['pickup_date', '>=', $dateNow],
            ['status', 0]
        ])->get();

        return view('courier.job', [
            'myData' => $myData,
            'jobs' => $jobs,
            'message' => $message,
        ]);
    }
    public function pickingUp($id, Request $request) {
        $myData = self::me();
        $data = ShipmentController::get([['id', $id]]);
        $job = $data->first();

        $photo = $request->file('pickup_photo');
        $photoFileName = time()."_".$photo->getClientOriginalName();
        $data->update(['pickup_photo' => $photoFileName]);
        $photo->storeAs('public/pickup_photo', $photoFileName);

        return redirect()->route('courier.find.detail', $job->id);
    }
    public function receive($shipmentID, Request $request) {
        $receiverID = $request->receiver_id;
        $data = Receiver::where('id', $receiverID);

        $photo = $request->file('bukti_kirim');
        $photoFileName = $receiverID."_".$photo->getClientOriginalName();
        $photo->storeAs('public/bukti_kirim', $photoFileName);

        $data->update(['received_photo' => $photoFileName]);

        // Check if it completed
        $receiver = $data->with('shipment.receivers')->first();
        $receivers = $receiver->shipment->receivers;
        $countDone = 0;
        foreach ($receivers as $rec) {
            if ($rec->received_photo != null) {
                $countDone += 1;
            }
        }
        if ($countDone == $receivers->count()) {
            $updateShipment = ShipmentController::get([['id', $receiver->shipment_id]])->update(['status' => 1]);
        }
        
        return redirect()->route('courier.find.detail', $receiver->shipment->id);
    }
    public function history(Request $request) {
        $myData = self::me();
        $month = $request->month;
        if ($request->month == "") {
            $month = date('m');
        }
        if ($month < 10 && $month[0] != 0) {
            $month = "0".$month;
        }
        $filterDate = date('Y-'.$month);

        $jobs = ShipmentController::get([
            ['courier_id', $myData->id],
            ['status', 1],
            ['pickup_date', 'LIKE', "%".$filterDate."%"]
        ])->with('receivers')->get();

        return view('courier.history', [
            'myData' => $myData,
            'month' => $month,
            'jobs' => $jobs
        ]);
    }
    public function revenue(Request $request) {
        $myData = self::me();
        $month = $request->month == "" ? date('m') : $request->month;
        $month = $month < 10 && $month[0] != 0 ? $month = "0".$month : $month;
        
        $filterDate = date('Y-'.$month);

        return view('courier.history', [
            'myData' => $myData,
            'month' => $month,
        ]);
    }
}
