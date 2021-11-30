<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    public function test() {
        $couriers = CourierController::get()->get();
        foreach ($couriers as $courier) {
            echo $courier->phone;
        }
    }
    public function send($phone, $message) {
        $response = Http::post(env('WHATSAPP_API_URL')."/send", [
            'phone' => $phone,
            'message' => $message,
        ]);

        return $response->body();
    }
}
