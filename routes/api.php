<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\EmployeeController;
use App\Http\Controllers\api\CountryController;
use App\Http\Controllers\api\CityController;
use App\Http\Controllers\api\CurrentBudgetController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\PositionController;
use App\Http\Controllers\api\PreSaleOrderController;
use App\Http\Controllers\api\ProjectLayoutController;
use App\Http\Controllers\api\RoleController;
use App\Http\Controllers\api\StateController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('signin', [AuthController::class, 'signin']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forgot-password', [AuthController::class, 'forgot_password']);
Route::post('reset-password', [AuthController::class, 'reset_password']);
Route::get('current_budget', [CurrentBudgetController::class, 'index']);

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
    Route::put('/positions/{position}', [PositionController::class, 'update']);
    Route::delete('/positions/{position}', [PositionController::class, 'destroy']);

    //Roles
    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/roles/{role}', [RoleController::class, 'show']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::delete('/roles/{role}', [RoleController::class, 'destroy']);

    //current budget
    Route::post('/current_budget', [CurrentBudgetController::class, 'store']);
    Route::put('/current_budget/{current_budget}', [CurrentBudgetController::class, 'update']);

    //Customers
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customers/{customer}', [CustomerController::class, 'show']);
    Route::put('/customers/{customer}', [CustomerController::class, 'update']);
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy']);

    //Projects layouts
    Route::get('/project_layouts', [ProjectLayoutController::class, 'index']);

    //Pre sales
    Route::get('/pre_sales', [PreSaleOrderController::class, 'index']);
    Route::post('/pre_sales', [PreSaleOrderController::class, 'store']);


});
