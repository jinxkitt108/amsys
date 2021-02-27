<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Users Routes
Route::apiResources(['user' => 'API\UserController']);
Route::get('auth_user', 'API\UserController@auth_user');

//Instructor Routes
Route::apiResources(['instructor' => 'API\InstructorController']);

//Job Order Routes
Route::apiResources(['job_order' => 'API\JobOrderController']);

//Class Level Routes
Route::apiResources(['class_level' => 'API\ClassLevelController']);
Route::get('class_info/{id}', 'API\ClassLevelController@showClassInfo');

//Management Routes
Route::post('college', 'API\ManagementController@storeCollege');
Route::get('college', 'API\ManagementController@showAllColleges');
Route::post('degree', 'API\ManagementController@storeDegree');
Route::get('degree', 'API\ManagementController@showAllDegrees');
Route::get('degree/{id}', 'API\ManagementController@getDegree');
Route::delete('degree/{id}', 'API\ManagementController@destroyDegree');
Route::post('course', 'API\ManagementController@storeCourse');

//Employee Attendance Routes
Route::apiResources(['attendance' => 'API\AttendanceController']);
Route::get('employee', 'API\AttendanceController@getAllEmployee');
Route::get('logs', 'API\AttendanceController@getAllLogs');
Route::post('logset', 'API\AttendanceController@getAllLogSet');
