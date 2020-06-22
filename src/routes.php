<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

Route::middleware('web')->group(function () {
    Route::get('password/renew', "Axterisko\\Inspinia\\Controller\\RenewPasswordController@showRenewForm")->name('password.expired');
    Route::post('password/renew', "Axterisko\\Inspinia\\Controller\\RenewPasswordController@renew")->name('password.renew');
});
