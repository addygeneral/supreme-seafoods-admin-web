<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OTPConfigurationController;

Route::get('otp-configuration', [OTPConfigurationController::class,'index']);
Route::post('otp-configuration/update', [OTPConfigurationController::class,'update']);