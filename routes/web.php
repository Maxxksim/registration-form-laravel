<?php

declare(strict_types=1);

use App\Http\Controllers\MemberController;
use App\Http\Controllers\StepController;
use Illuminate\Support\Facades\Route;

Route::controller(StepController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/register/steps/one', 'getStepOne');
    Route::get('/register/steps/two', 'getStepTwo');
    Route::get('/register/steps/thanks', 'getStepThanks');
    Route::post('/register/steps/one', 'stepOne');
    Route::post('/register/steps/two', 'stepTwo');
});

Route::get('/members', [MemberController::class, 'index']);
