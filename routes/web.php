<?php

use Illuminate\Support\Facades\Route;

Route::get('/', "UserController@index")->name('user.index');
Route::get('lacak', "UserController@check")->name('user.check');
Route::get('tentang', "UserController@about")->name('user.about');
Route::get('kirim', "UserController@send")->name('user.send');
Route::post('kirim', "UserController@sending")->name('user.sending');
Route::get('selesai', "UserController@done")->name('user.done');
Route::get('bayar', "UserController@pay")->name('user.pay');
Route::get('tarif', "UserController@pricing")->name('user.pricing');

Route::get('pwd', function () {
    return bcrypt("inikatasandi");
});

Route::group(['prefix' => "kurir"], function () {
    Route::get('login', "CourierController@loginPage")->name('courier.loginPage');
    Route::post('login', "CourierController@login")->name('courier.login');
    Route::get('logout', "CourierController@logout")->name('courier.logout');

    Route::get('home', "CourierController@home")->name('courier.home')->middleware('Courier');
    Route::get('find', "CourierController@find")->name('courier.find')->middleware('Courier');
    Route::get('find/{id}', "CourierController@findDetail")->name('courier.find.detail')->middleware('Courier');
    Route::post('find/{id}/grab', "CourierController@grabShipment")->name('courier.find.grab')->middleware('Courier');
    Route::get('job', "CourierController@job")->name('courier.job')->middleware('Courier');
    Route::post('job/{id}/pickup', "CourierController@pickingUp")->name('courier.job.pickup')->middleware('Courier');
    Route::post('job/{id}/receive', "CourierController@receive")->name('courier.job.receive')->middleware('Courier');
    Route::get('profile', "CourierController@profile")->name('courier.profile')->middleware('Courier');
    Route::get('profile/edit', "CourierController@editProfile")->name('courier.profile.edit')->middleware('Courier');
    Route::post('profile/edit', "CourierController@editProfile")->name('courier.profile.edit')->middleware('Courier');

    Route::get('history', "CourierController@history")->name('courier.history')->middleware('Courier');

    Route::get('/', function () {
        return redirect()->route('courier.home');
    });
});

Route::group(['prefix' => "admin"], function () {
    Route::get('login', "AdminController@loginPage")->name('admin.loginPage');
    Route::post('login', "AdminController@login")->name('admin.login');
    Route::get('logout', "AdminController@logout")->name('admin.logout');

    Route::get('dashboard', "AdminController@dashboard")->name('admin.dashboard')->middleware('Admin');
    Route::group(['prefix' => "schedule"], function () {
        Route::post('store', "ScheduleController@store")->name('admin.schedule.store')->middleware('Admin');
        Route::post('update', "ScheduleController@update")->name('admin.schedule.update')->middleware('Admin');
        Route::post('delete', "ScheduleController@delete")->name('admin.schedule.delete')->middleware('Admin');
        Route::get('/', "AdminController@schedule")->name('admin.schedule')->middleware('Admin');
    });
    
    Route::group(['prefix' => "courier"], function () {
        Route::post('store', "CourierController@store")->name('admin.courier.store')->middleware('Admin');
        Route::post('update', "CourierController@update")->name('admin.courier.update')->middleware('Admin');
        Route::post('delete', "CourierController@delete")->name('admin.courier.delete')->middleware('Admin');
        Route::get('/', "AdminController@courier")->name('admin.courier')->middleware('Admin');
    });

    Route::get('report', "AdminController@report")->name('admin.report')->middleware('Admin');
});
