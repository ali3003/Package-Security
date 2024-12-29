<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordsController;

Route::post('/authentication/createAccount', [AuthController::class,'createAccount']);
Route::post('/authentication/logToAccount', [AuthController::class,'logToAccount']);
Route::post('/authentication/conformEmail', [AuthController::class,'conformEmail']);
Route::post('/authentication/requestEmailConformationCode', [AuthController::class,'requestEmailConformationCode']);
Route::post('/authentication/resetPassword', [AuthController::class,'resetPassword']);
Route::post('/authentication/setPassword', [AuthController::class,'setNewPassword']);


Route::get('/passwordsStorage', [PasswordsController::class,'index'])->middleware('isUserIn');
Route::patch('/passwordsStorage', [PasswordsController::class,'update'])->middleware('isUserIn');
Route::delete('/passwordsStorage', [PasswordsController::class,'destroy'])->middleware('isUserIn');
Route::post('/passwordsStorage', [PasswordsController::class,'store'])->middleware('isUserIn');
