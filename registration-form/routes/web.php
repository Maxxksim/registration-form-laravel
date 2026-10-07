<?php

declare(strict_types=1);

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\StepController;
use App\Http\Middleware\HandleOrderSteps;
use Illuminate\Support\Facades\Route;

Route::controller(StepController::class)->group(function () {
    Route::get('/', 'index')->name('index.show');

    Route::middleware(HandleOrderSteps::class.':one')->group(function () {
        Route::get('/register/steps/one', 'getStepOne')->name('steps.one.show');
        Route::post('/register/steps/one', 'stepOne')->name('steps.one');
    });
    Route::middleware(HandleOrderSteps::class.':two')->group(function () {
        Route::get('/register/steps/two', 'getStepTwo')->name('steps.two.show');
        Route::post('/register/steps/two', 'stepTwo')->name('steps.two');
    });

    Route::get('/register/steps/thanks', 'getStepThanks')->name('steps.thanks.show')->middleware(HandleOrderSteps::class.':thanks');
    Route::get('/register/start', 'startOver')->name('start.over');
});

Route::get('/members', [MemberController::class, 'index']);
Route::get('/admin/panel', [AdminPanelController::class, 'index'])->name('admin.panel');
Route::get('/admin/login', [AdminAuthController::class, 'index'])->name('admin.login.index');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');

Route::middleware('auth')->group(function () {
    Route::patch('/admin/members/{member}', [MemberController::class, 'update'])->name('admin.members.update');
    Route::patch('/admin/members/{member}/visibility', [MemberController::class, 'switchVisibility'])->name('admin.members.visibility');
    Route::delete('/admin/members/{member}', [MemberController::class, 'delete'])->name('admin.members.delete');
});
