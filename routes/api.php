<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscribeController;

Route::post('/subscribe', [SubscribeController::class, 'store']);