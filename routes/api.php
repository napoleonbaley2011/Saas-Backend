<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MicroempresaController;
use App\Http\Controllers\PlanController;
use Illuminate\Foundation\Mix;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/registerUsers', [AuthController::class, 'registerUsers']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/getAllPlans', [PlanController::class, 'getAllPlans']);  
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'micro'
], function () {
   Route::get('/allMicroempresas', [MicroempresaController::class, 'getAllMicroempresas']);
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'auth'
], function () {
    Route::get('/adminMicroempresas', [AdminController::class, 'adminMicroempresas']);
    Route::put('/updateMicroempresaStatus/{id}', [AdminController::class, 'updateMicroempresaStatus']);
    Route::get('/getAllPlans', [AdminController::class, 'getAllPlans']);  
});

Route::group([
    'middleware' => 'auth:api',  
    'prefix' => 'auth'
], function () {
    Route::post('/changePassword', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group([
    'middleware' => 'auth:api',  
    'prefix' => 'plans'
], function () {
    Route::post('/', [PlanController::class, 'createPlan']);  
    Route::get('{id}', [PlanController::class, 'getPlan']);   
    Route::put('{id}', [PlanController::class, 'updatePlan']);
    Route::delete('{id}', [PlanController::class, 'deletePlan']); 
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'empresa'
], function () {
    Route::post('/createNewEmpresa', [MicroempresaController::class, 'create']);  
    Route::put('{id}', [MicroempresaController::class, 'edit']); 
});