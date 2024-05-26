<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AmoWebHookController;

Route::post('amo-webhook', [AmoWebHookController::class, 'handle'] );
