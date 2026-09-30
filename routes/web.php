<?php

declare(strict_types=1);

use App\Http\Controllers\MemberController;
use App\Http\Controllers\StepController;
use App\Http\Middleware\HandleOrderSteps;
use Illuminate\Support\Facades\Route;

Route::controller(StepController::class)->group(function () {
    Route::get('/', 'index');

    Route::middleware(HandleOrderSteps::class.':one')->group(function () {
        Route::get('/register/steps/one', 'getStepOne');
        Route::post('/register/steps/one', 'stepOne');
    });
    Route::middleware(HandleOrderSteps::class.':two')->group(function () {
        Route::get('/register/steps/two', 'getStepTwo');
        Route::post('/register/steps/two', 'stepTwo');
    });

    Route::get('/register/steps/thanks', 'getStepThanks')->middleware(HandleOrderSteps::class.':thanks');
});

Route::get('/members', [MemberController::class, 'index']);
