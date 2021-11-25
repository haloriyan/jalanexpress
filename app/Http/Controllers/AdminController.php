<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public static function me() {
        $myData = Auth::guard('admin')->user();
    }
    public function loginPage() {
        $message = Session::get('message');
        return view('admin.login', ['message' => $message]);
    }
    public function login(Request $request) {
        $loggingIn = Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (!$loggingIn) {
            return redirect()->route('admin.loginPage')->withErrors(['Email atau Password salah']);
        }
        
        return redirect()->route('admin.dashboard');
    }
    public function logout() {
        $loggingOut = Auth::guard('admin')->logout();
        return redirect()->route('admin.loginPage')->with(['message' => "Berhasil logout"]);
    }
    public function dashboard() {
        return view('admin.dashboard');
    }
    public function schedule() {
        $myData = self::me();
        $message = Session::get('message');
        $schedules = ScheduleController::get()->orderBy('region', 'ASC')->get();

        return view('admin.schedule', [
            'myData' => $myData,
            'schedules' => $schedules,
            'message' => $message
        ]);
    }
    public function courier() {
        $myData = self::me();
        $message = Session::get('message');
        $couriers = CourierController::get()->orderBy('created_at', 'DESC')->get();

        return view('admin.courier', [
            'myData' => $myData,
            'couriers' => $couriers,
            'message' => $message
        ]);
    }
}
