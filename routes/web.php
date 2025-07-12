<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\authController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\subCategoryController;
use App\Http\Controllers\typeController;
use App\Http\Controllers\subTypeController;
use App\Http\Controllers\makeController;
use App\Http\Controllers\modelController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\employeeController;
use App\Http\Controllers\settingController;
use App\Http\Controllers\commonController;

Route::group(['middleware' => ['alreadyLogin', 'preventBackHistory', 'rememberMe', 'handleServerError', 'storeRequestLogs']], function () {

    Route::get('/', [authController::class, 'index'])->name('login');
    Route::get('login', [authController::class, 'index']);
    Route::post('login', [authController::class, 'login']);
    Route::get('logout', [authController::class, 'logout']);

    Route::get('twoStepVerification/{UID}', [authController::class, 'twoStepVerificationIndex']);
    Route::post('twoStepVerification', [authController::class, 'twoStepVerification']);
    Route::get('otpResend/{UID}', [authController::class, 'otpResend']);

    Route::get('forgot', [authController::class, 'forgotIndex']);
    Route::post('forgot', [authController::class, 'find']);
    Route::get('forgot/{UID}', [authController::class, 'verificationIndex']);
    Route::post('forgot/verification', [authController::class, 'verification']);
    Route::get('change-password/{UID}', [authController::class, 'changePasswordIndex']);
    Route::post('change-password', [authController::class, 'changePassword']);

});

Route::group(['middleware' => ['loginCheck', 'handleServerError', 'preventBackHistory', 'storeRequestLogs', 'accessManagement']], function () {

    Route::get('/home', [homeController::class, 'index'])->name('home');

    Route::resource('admin', adminController::class);
    Route::patch('admin/{uid}/status', [adminController::class, 'status']);

    Route::resource('category', categoryController::class);
    Route::patch('category/{uid}/status', [categoryController::class, 'status']);

    Route::resource('subCategory', subCategoryController::class);
    Route::patch('subCategory/{uid}/status', [subCategoryController::class, 'status']);

    Route::resource('type', typeController::class);
    Route::patch('type/{uid}/status', [typeController::class, 'status']);

    Route::resource('subType', subTypeController::class);
    Route::patch('subType/{uid}/status', [subTypeController::class, 'status']);

    Route::resource('make', makeController::class);
    Route::patch('make/{uid}/status', [makeController::class, 'status']);

    Route::resource('model', modelController::class);
    Route::patch('model/{uid}/status', [modelController::class, 'status']);

    Route::resource('role', roleController::class);
    Route::patch('role/{uid}/status', [roleController::class, 'status']);
    Route::get('role/permission/{uid}', [roleController::class, 'permission']);
    Route::post('role/permission', [roleController::class, 'permissionSave']);

    Route::resource('employee', employeeController::class);
    Route::patch('employee/{uid}/status', [employeeController::class, 'status']);

    Route::get('setting', [settingController::class, 'index']);
    Route::post('setting/personal', [settingController::class, 'personal']);
    Route::post('setting/twoStepVerification', [settingController::class, 'twoStepVerification']);
    Route::post('setting/password', [settingController::class, 'password']);
    Route::post('setting/profile', [settingController::class, 'profile']);
    Route::post('setting/cover', [settingController::class, 'cover']);
    Route::post('setting/accountDelete', [settingController::class, 'accountDelete']);

});

Route::get('/common/category', [commonController::class, 'category']);
    Route::get('/common/type', [commonController::class, 'type']);
    Route::get('/common/make', [commonController::class, 'make']);
    Route::get('/common/role', [commonController::class, 'role']);


