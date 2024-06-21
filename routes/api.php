<?php

use App\Http\Controllers\api\DashboardController;
use Illuminate\Http\Request;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TeacherController;
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

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('get.user');
    Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');
    Route::post('/change-info', [AuthController::class, 'changeInfo'])->name('user.change-info');
    Route::post('/change-pass', [AuthController::class, 'changePassword'])->name('user.change-password');
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Class
    Route::prefix('class')->group(function () {
        Route::get('/list', [ClassController::class, 'getListApi'])->name('get.class-all-api');
        Route::get('/detail/{class_id}', [ClassController::class, 'detailApi'])->name('get.class-detail-api');
        Route::get('/lesson', [ClassController::class, 'getLessonTodayApi'])->name('get.lesson-today-api');
        Route::post('/lesson_schedule_task', [ClassController::class, 'getLessonScheduleTaskApi'])->name('get.lesson-all-schedule-api');
        Route::get('/task', [ClassController::class, 'getTaskApi'])->name('get.task-api');
    });

    // Lesson
    Route::prefix('lesson')->group(function () {
        Route::get('/detail/{lesson_id}', [LessonController::class, 'detailApi'])->name('get.lesson-detail-api');
    });

    // Homework
    Route::prefix('homework')->group(function () {
        Route::get('/lists', [HomeworkController::class, 'listApi'])->name('get.list-homework-api');
        Route::get('/questions/{homework_id}', [HomeworkController::class, 'listQuestionApi'])->name('get.list-question-api');
        Route::post('/result/store', [HomeworkController::class, 'storeResultApi'])->name('store.result-api');
    });

    // Teacher
    Route::prefix('teacher')->group(function () {
        Route::get('/lists', [TeacherController::class, 'listApi'])->name('get.list-teacher-api');
    });

    // Attendance
    Route::prefix('attendance')->group(function () {
        Route::get('/info_classes', [AttendanceController::class, 'listClassLessons'])->name('get.list-class-api');
        Route::get('/lists', [AttendanceController::class, 'listApi'])->name('get.list-attendance-api');
        Route::post('/store', [AttendanceController::class, 'storeApi'])->name('get.store-attendance-api');
    });
});

// Admin dashboard api 
Route::prefix('dashboard')->group(function () {
    Route::get('/admin', [DashboardController::class, 'admin'])->name('get.admin-dashboard-api');
    Route::get('/teacher/{id}', [DashboardController::class, 'teacher'])->name('get.teacher-dashboard-api');
    Route::get('/schedule/teacher/{id}', [DashboardController::class, 'scheduleTeacher'])->name('get.teacher-dashboard-api');
});
    