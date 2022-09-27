<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupToStudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('users', UserController::class);
    Route::get('allActiveUsers', [UserController::class, 'getActiveUsers']);
    Route::put('user/change_status/{id}', [UserController::class, 'changeStatus']);
    Route::apiResource('student', StudentController::class);
    Route::post('student/get_active_students', [StudentController::class, 'getActiveStudents']);
    Route::put('student/change_status/{id}', [StudentController::class, 'changeStatus']);
    Route::apiResource('subject', SubjectController::class)->except('show', 'destroy');
    Route::put('subject/change_status/{id}', [SubjectController::class, 'changeStatus']);
    Route::apiResource('teacher', TeacherController::class)->except('destroy');
    Route::get('teachers_of_subject', [TeacherController::class, 'getTeachersOfSubject']);
    Route::apiResource('group', GroupController::class)->except('destroy');
    Route::get('groups_teacher/{id}', [GroupController::class, 'getGroupsOfTeacher']);
    Route::get('groups_student/{id}', [GroupController::class, 'getGroupsOfStudent']);
    Route::put('group/change_status/{id}', [GroupController::class, 'changeStatus']);
    Route::apiResource('group_to_student', GroupToStudentController::class)->except('show', 'destroy');
    Route::get('group_to_student/students_of_the_group/{id}', [GroupToStudentController::class, 'getStudentsOfGroup']);
    Route::apiResource('payment', PaymentController::class);
    Route::post('paymentHistory/teacher', [PaymentHistoryController::class, 'getPaymentHistoryOfTeacher']);
    Route::apiResource('attendance', AttendanceController::class)->except('delete');
});
