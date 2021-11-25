<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Models\Courier;
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

        return view('courier.home', [
            'myData' => $myData
        ]);
    }
    public function profile() {
        $myData = self::me();

        return view('courier.profile', [
            'myData' => $myData
        ]);
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
        
        $job = ShipmentController::get([['id', $id]]);
        $job->update([
            'courier_id' => $myData->id
        ]);

        return redirect()->route('courier.job')->with(['message' => "Kiriman ini sekarang dapat Anda ambil dan antarkan"]);
    }
    public function job() {
        $myData = self::me();
        $message = Session::get('message');
        
        $jobs = ShipmentController::get([['courier_id', $myData->id]])->get();

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
}
