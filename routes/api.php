<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\EmployeeController;
use App\Http\Controllers\api\CountryController;
use App\Http\Controllers\api\CityController;
use App\Http\Controllers\api\PositionController;
use App\Http\Controllers\api\RoleController;
use App\Http\Controllers\api\StateController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('signin', [AuthController::class, 'signin']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forgot-password', [AuthController::class, 'forgot_password']);
Route::post('reset-password', [AuthController::class, 'reset_password']);

Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::get('user-profile', [AuthController::class, 'user_profile']);
    Route::get('users', [AuthController::class, 'all_users']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::put('users/{user}', [UserController::class, 'update']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('/users/roles', [UserController::class, 'add_role']);
    Route::post('/users/roles/remove', [UserController::class, 'remove_role']);

    //Employees
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::get('/employees/{employee}', [EmployeeController::class, 'show']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::put('/employees/{employee}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);

    //Countries, States, Cities
    Route::get('/countries', [CountryController::class, 'index']);
    Route::get('/states', [StateController::class, 'index']);
    Route::get('/cities', [CityController::class, 'index']);
    Route::get('/cities/{city}', [CityController::class, 'show']);

    //Positions
    Route::get('/positions', [PositionController::class, 'index']);
    Route::get('/positions/{position}', [PositionController::class, 'show']);
    Route::post('/positions', [PositionController::class, 'store']);

    //Roles
    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/roles/{role}', [RoleController::class, 'show']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::put('/roles/{role}', [RoleController::class, 'update_role_status']);
});
