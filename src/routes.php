<?php

Route::get('password/renew', "\\App\\Http\\Controllers\\Auth\\RenewPasswordController@showRenewForm")->name('password.expired');
Route::post('password/renew', "\\App\\Http\\Controllers\\Auth\\RenewPasswordController@renew")->name('password.renew');

