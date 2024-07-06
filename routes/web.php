<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Setting;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** for side bar menu active */
function set_active($route)
{
    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }

    return Request::path() == $route ? 'active' : '';
}

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', function () {
        return view('home');
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Auth'], function () {
    // ----------------------------login ------------------------------//
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::post('change/password', 'changePassword')->name('change/password');
    });

});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    // -------------------------- main dashboard ----------------------//
    Route::controller(HomeController::class)->group(function () {
        Route::get('/home', 'index')->middleware(['auth', 'admin'])->name('home');
        Route::get('user/profile/page', 'userProfile')->middleware(['auth', 'manage'])->name('user/profile/page');
        Route::get('user/profile/edit', 'userProfileEdit')->middleware(['auth', 'manage'])->name('user/profile/edit');
        Route::post('user/profile/update', 'userProfileUpdate')->middleware(['auth', 'manage'])->name('user/profile/update');
        Route::get('teacher/dashboard/{id}', 'teacherDashboardIndex')->middleware(['auth', 'manage'])->name('teacher/dashboard');
        Route::get('student/dashboard/{id}', 'studentDashboardIndex')->middleware(['auth', 'admin'])->name('student/dashboard');
    });

    // ------------------------ student -------------------------------//
    Route::middleware(['auth', 'admin'])->controller(StudentController::class)->group(function () {
        Route::get('student/list', 'student')->name('student/list'); // list student
        Route::get('student/add/page', 'studentAdd')->name('student/add/page'); // page student
        Route::post('student/add/save', 'studentSave')->name('student/add/save'); // save record student
        Route::get('student/edit/{id}', 'studentEdit'); // view for edit
        Route::post('student/update', 'studentUpdate')->name('student/update'); // update record student
        Route::post('student/delete', 'studentDelete')->name('student/delete'); // delete record student
    });

    // ------------------------ teacher -------------------------------//
    Route::middleware(['auth', 'admin'])->controller(TeacherController::class)->group(function () {
        Route::get('teacher/add/page', 'teacherAdd')->name('teacher/add/page'); // page teacher
        Route::get('teacher/list/page', 'teacherList')->name('teacher/list/page'); // page teacher
        Route::post('teacher/save', 'saveRecord')->name('teacher/save'); // save record
        Route::get('teacher/edit/{user_id}', 'editRecord'); // view teacher record
        Route::post('teacher/update', 'updateRecordTeacher')->name('teacher/update'); // update record
        Route::post('teacher/delete', 'teacherDelete')->name('teacher/delete'); // delete record teacher
    });

    // ------------------------ room -------------------------------//
    Route::middleware(['auth', 'admin'])->controller(RoomController::class)->group(function () {
        Route::get('room/list', 'room')->name('room/list'); // list room
        Route::get('room/add/page', 'roomAdd')->name('room/add/page'); // page room
        Route::post('room/add/save', 'roomSave')->name('room/add/save'); // save record room
        Route::get('room/edit/{id}', 'roomEdit'); // view for edit
        Route::post('room/update', 'roomUpdate')->name('room/update'); // update record room
        Route::post('room/delete', 'roomDelete')->name('room/delete'); // delete record room
    });

    // ------------------------ question -------------------------------//
    Route::middleware(['auth', 'manage'])->controller(QuestionController::class)->group(function () {
        Route::get('question/list', 'question')->name('question/list'); // list question
        Route::get('question/add/page', 'questionAdd')->name('question/add/page'); // page question
        Route::post('question/add/save', 'questionSave')->name('question/add/save'); // save record question
        Route::get('question/edit/{id}', 'questionEdit'); // view for edit
        Route::post('question/update', 'questionUpdate')->name('question/update'); // update record question
        Route::post('question/delete', 'questionDelete')->name('question/delete'); // delete record question
    });

    // ------------------------ homework -------------------------------//
    Route::middleware(['auth', 'manage'])->controller(HomeworkController::class)->group(function () {
        Route::get('homework/list', 'homework')->middleware('auth')->name('homework/list'); // list homework
        Route::get('homework/add/page', 'homeworkAdd')->middleware('auth')->name('homework/add/page'); // page homework
        Route::post('homework/add/save', 'homeworkSave')->name('homework/add/save'); // save record homework
        Route::get('homework/edit/{id}', 'homeworkEdit'); // view for edit
        Route::post('homework/update', 'homeworkUpdate')->name('homework/update'); // update record homework
        Route::post('homework/delete', 'homeworkDelete')->name('homework/delete'); // delete record homework
    });

    // ------------------------ document -------------------------------//
    Route::middleware(['auth', 'manage'])->controller(DocumentController::class)->group(function () {
        Route::get('document/list', 'document')->middleware('auth')->name('document/list'); // list document
        Route::get('document/add/page', 'documentAdd')->middleware('auth')->name('document/add/page'); // page document
        Route::post('document/upload', 'documentUpload')->middleware('auth')->name('document/upload'); // page document
        Route::post('document/delete', 'documentDelete')->name('document/delete'); // delete record document
    });

    // ------------------------ class -------------------------------//
    Route::controller(ClassController::class)->group(function () {
        Route::get('class/list', 'class')->middleware(['auth', 'manage'])->name('class/list'); // list class
        Route::get('class/add/page', 'classAdd')->middleware(['auth', 'admin'])->name('class/add/page'); // page class
        Route::post('class/add/save', 'classSave')->middleware(['auth', 'admin'])->name('class/add/save'); // save record class
        Route::get('class/edit/{id}', 'classEdit')->middleware(['auth', 'admin']); // view for edit
        Route::post('class/update', 'classUpdate')->middleware(['auth', 'admin'])->name('class/update'); // update record class
    });

    Route::controller(LessonController::class)->group(function () {
        Route::get('lesson/list/{id}', 'lesson')->middleware(['auth', 'manage'])->name('lesson/list'); // list lesson
        Route::get('lesson/add/page/{id}', 'lessonAdd')->middleware(['auth', 'manage']); // page lesson
        Route::post('lesson/add/save', 'lessonSave')->middleware(['auth', 'manage'])->name('lesson/add/save'); // save record lesson
        Route::get('lesson/edit/{id}/class/{class_id}', 'lessonEdit')->middleware(['auth', 'manage']); // view for edit
        Route::post('lesson/update', 'lessonUpdate')->name('lesson/update')->middleware(['auth', 'manage']); // update record lesson
        Route::post('lesson/delete', 'lessonDelete')->name('lesson/delete')->middleware(['auth', 'admin']); // delete record lesson

        Route::get('lesson/homework/{lesson_id}', 'lessonHomework'); // view for edit
        Route::post('lesson/homework/{lesson_id}', 'postLessonHomework'); // view for edit
        Route::get('lesson/attendance/{id}', 'lessonAttendance'); // view for edit
    });

    Route::middleware(['auth', 'manage'])->controller(AttendanceController::class)->group(function () {
        Route::get('attendance/list/{id}', 'attendance')->name('attendance/list'); // list attendance
        Route::get('attendance/add/page/{id}', 'attendanceAdd'); // page attendance
        Route::post('attendance/add/save', 'attendanceSave')->name('attendance/add/save'); // save record attendance
        Route::get('attendance/edit/{id}/class/{class_id}', 'attendanceEdit'); // view for edit
        Route::post('attendance/update', 'attendanceUpdate')->name('attendance/update'); // update record attendance
        Route::post('attendance/delete', 'attendanceDelete')->name('attendance/delete'); // delete record attendance
    });

    Route::middleware(['auth', 'manage'])->controller(ResultController::class)->group(function () {
        Route::get('result/list/{id}', 'result')->name('result/list'); // list result
        Route::get('result/add/page/{id}', 'resultAdd'); // page result
        Route::post('result/add/save', 'resultSave')->name('result/add/save'); // save record result
        Route::get('result/edit/{id}/class/{class_id}', 'resultEdit'); // view for edit
        Route::post('result/update', 'resultUpdate')->name('result/update'); // update record result
        Route::post('result/delete', 'resultDelete')->name('result/delete'); // delete record result
    });
});

Route::get('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
