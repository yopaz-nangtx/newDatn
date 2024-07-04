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
        Route::get('/home', 'index')->middleware('auth')->name('home');
        Route::get('user/profile/page', 'userProfile')->middleware('auth')->name('user/profile/page');
        Route::get('user/profile/edit', 'userProfileEdit')->middleware('auth')->name('user/profile/edit');
        Route::post('user/profile/update', 'userProfileUpdate')->middleware('auth')->name('user/profile/update');
        Route::get('teacher/dashboard/{id}', 'teacherDashboardIndex')->middleware('auth')->name('teacher/dashboard');
        Route::get('student/dashboard/{id}', 'studentDashboardIndex')->middleware('auth')->name('student/dashboard');
    });

    // ------------------------ setting -------------------------------//
    Route::controller(Setting::class)->group(function () {
        Route::get('setting/page', 'index')->middleware('auth')->name('setting/page');
    });

    // ------------------------ student -------------------------------//
    Route::controller(StudentController::class)->group(function () {
        Route::get('student/list', 'student')->middleware('auth')->name('student/list'); // list student
        Route::get('student/add/page', 'studentAdd')->middleware('auth')->name('student/add/page'); // page student
        Route::post('student/add/save', 'studentSave')->name('student/add/save'); // save record student
        Route::get('student/edit/{id}', 'studentEdit'); // view for edit
        Route::post('student/update', 'studentUpdate')->name('student/update'); // update record student
        Route::post('student/delete', 'studentDelete')->name('student/delete'); // delete record student
    });

    // ------------------------ teacher -------------------------------//
    Route::controller(TeacherController::class)->group(function () {
        Route::get('teacher/add/page', 'teacherAdd')->middleware('auth')->name('teacher/add/page'); // page teacher
        Route::get('teacher/list/page', 'teacherList')->middleware('auth')->name('teacher/list/page'); // page teacher
        Route::post('teacher/save', 'saveRecord')->middleware('auth')->name('teacher/save'); // save record
        Route::get('teacher/edit/{user_id}', 'editRecord'); // view teacher record
        Route::post('teacher/update', 'updateRecordTeacher')->middleware('auth')->name('teacher/update'); // update record
        Route::post('teacher/delete', 'teacherDelete')->name('teacher/delete'); // delete record teacher
    });

    // ------------------------ room -------------------------------//
    Route::controller(RoomController::class)->group(function () {
        Route::get('room/list', 'room')->middleware('auth')->name('room/list'); // list room
        Route::get('room/add/page', 'roomAdd')->middleware('auth')->name('room/add/page'); // page room
        Route::post('room/add/save', 'roomSave')->name('room/add/save'); // save record room
        Route::get('room/edit/{id}', 'roomEdit'); // view for edit
        Route::post('room/update', 'roomUpdate')->name('room/update'); // update record room
        Route::post('room/delete', 'roomDelete')->name('room/delete'); // delete record room
    });

    // ------------------------ question -------------------------------//
    Route::controller(QuestionController::class)->group(function () {
        Route::get('question/list', 'question')->middleware('auth')->name('question/list'); // list question
        Route::get('question/add/page', 'questionAdd')->middleware('auth')->name('question/add/page'); // page question
        Route::post('question/add/save', 'questionSave')->name('question/add/save'); // save record question
        Route::get('question/edit/{id}', 'questionEdit'); // view for edit
        Route::post('question/update', 'questionUpdate')->name('question/update'); // update record question
        Route::post('question/delete', 'questionDelete')->name('question/delete'); // delete record question
    });

    // ------------------------ homework -------------------------------//
    Route::controller(HomeworkController::class)->group(function () {
        Route::get('homework/list', 'homework')->middleware('auth')->name('homework/list'); // list homework
        Route::get('homework/add/page', 'homeworkAdd')->middleware('auth')->name('homework/add/page'); // page homework
        Route::post('homework/add/save', 'homeworkSave')->name('homework/add/save'); // save record homework
        Route::get('homework/edit/{id}', 'homeworkEdit'); // view for edit
        Route::post('homework/update', 'homeworkUpdate')->name('homework/update'); // update record homework
        Route::post('homework/delete', 'homeworkDelete')->name('homework/delete'); // delete record homework
    });

    // ------------------------ document -------------------------------//
    Route::controller(DocumentController::class)->group(function () {
        Route::get('document/list', 'document')->middleware('auth')->name('document/list'); // list document
        Route::get('document/add/page', 'documentAdd')->middleware('auth')->name('document/add/page'); // page document
        Route::post('document/upload', 'documentUpload')->middleware('auth')->name('document/upload'); // page document
        Route::post('document/delete', 'documentDelete')->name('document/delete'); // delete record document
    });

    // ------------------------ class -------------------------------//
    Route::controller(ClassController::class)->group(function () {
        Route::get('class/list', 'class')->middleware('auth')->name('class/list'); // list class
        Route::get('class/add/page', 'classAdd')->middleware('auth')->name('class/add/page'); // page class
        Route::post('class/add/save', 'classSave')->name('class/add/save'); // save record class
        Route::get('class/edit/{id}', 'classEdit'); // view for edit
        Route::post('class/update', 'classUpdate')->name('class/update'); // update record class
    });

    Route::controller(LessonController::class)->group(function () {
        Route::get('lesson/list/{id}', 'lesson')->middleware('auth')->name('lesson/list'); // list lesson
        Route::get('lesson/add/page/{id}', 'lessonAdd')->middleware('auth'); // page lesson
        Route::post('lesson/add/save', 'lessonSave')->name('lesson/add/save'); // save record lesson
        Route::get('lesson/edit/{id}/class/{class_id}', 'lessonEdit'); // view for edit
        Route::post('lesson/update', 'lessonUpdate')->name('lesson/update'); // update record lesson
        Route::post('lesson/delete', 'lessonDelete')->name('lesson/delete'); // delete record lesson

        Route::get('lesson/homework/{lesson_id}', 'lessonHomework'); // view for edit
        Route::post('lesson/homework/{lesson_id}', 'postLessonHomework'); // view for edit
        Route::get('lesson/attendance/{id}', 'lessonAttendance'); // view for edit
    });

    Route::controller(AttendanceController::class)->group(function () {
        Route::get('attendance/list/{id}', 'attendance')->middleware('auth')->name('attendance/list'); // list attendance
        Route::get('attendance/add/page/{id}', 'attendanceAdd')->middleware('auth'); // page attendance
        Route::post('attendance/add/save', 'attendanceSave')->name('attendance/add/save'); // save record attendance
        Route::get('attendance/edit/{id}/class/{class_id}', 'attendanceEdit'); // view for edit
        Route::post('attendance/update', 'attendanceUpdate')->name('attendance/update'); // update record attendance
        Route::post('attendance/delete', 'attendanceDelete')->name('attendance/delete'); // delete record attendance
    });

    Route::controller(ResultController::class)->group(function () {
        Route::get('result/list/{id}', 'result')->middleware('auth')->name('result/list'); // list result
        Route::get('result/add/page/{id}', 'resultAdd')->middleware('auth'); // page result
        Route::post('result/add/save', 'resultSave')->name('result/add/save'); // save record result
        Route::get('result/edit/{id}/class/{class_id}', 'resultEdit'); // view for edit
        Route::post('result/update', 'resultUpdate')->name('result/update'); // update record result
        Route::post('result/delete', 'resultDelete')->name('result/delete'); // delete record result
    });
});

Route::get('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
