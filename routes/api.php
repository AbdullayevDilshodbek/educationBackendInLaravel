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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('users_insert', 'App\Http\Controllers\UserController@insert');
Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => 'auth:api'], function () {
    Route::apiResource('users', 'UserController');
    Route::get('allActiveUsers', 'UserController@getActiveUser');
    Route::put('user/change_status/{id}', 'UserController@changeStatus');
    Route::apiResource('student', 'StudentController');
    Route::post('student/get_active_students', 'StudentController@getActiveStudents');
    Route::put('student/change_status/{id}', 'StudentController@changeStatus');
    Route::apiResource('subject', 'SubjectController')->except('show', 'destroy');
    Route::put('subject/change_status/{id}', 'SubjectController@changeStatus');
    Route::apiResource('teacher', 'TeacherController')->except('destroy');
    Route::get('teachers_of_subject', 'TeacherController@getTeachersOfSubject');
    Route::apiResource('group', 'GroupController')->except('destroy');
    Route::get('groups_teacher/{id}', 'GroupController@getGroupsOfTeacher');
    Route::get('groups_student/{id}', 'GroupController@getGroupsOfStudent');
    Route::put('group/change_status/{id}', 'GroupController@changeStatus');
    Route::apiResource('group_to_student', 'GroupToStudentController')->except('show', 'destroy');
    Route::get('group_to_student/students_of_the_group/{id}', 'GroupToStudentController@getStudentsOfGroup');
    Route::apiResource('payment', 'PaymentController');
    Route::post('paymentHistory/teacher', 'PaymentHistoryController@getPaymentHistoryOfTeacher');
    Route::apiResource('attendance', 'AttendanceController')->except('delete');
});
