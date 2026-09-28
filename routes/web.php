<?php

declare(strict_types=1);

use App\Http\Controllers\StepController;
use Illuminate\Support\Facades\Route;

Route::controller(StepController::class)->group(function () {
    Route::get('/','index');
    Route::get('/register/steps/one', 'getStepOne');
    Route::post('/register/steps/one', 'stepOne');
});
