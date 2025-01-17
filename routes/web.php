<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotResponsesController;
use App\Http\Controllers\MessageController;
use SleepingOwl\Admin\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// https://api.telegram.org/bot7122057597:AAGMgULqHhuM3iJOMBM15u1Bbnk3T4Hj7O8/setWebhook?url=https://875a-94-41-222-43.ngrok-free.app/webhook

Route::post('/webhook', [BotResponsesController::class, 'handle']);

Route::post('/sendMassMessage', [MessageController::class,'sendMassMessage'])->name('sendMassMessage');
