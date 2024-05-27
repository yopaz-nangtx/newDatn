<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Setting;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();
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
        Route::get('teacher/dashboard', 'teacherDashboardIndex')->middleware('auth')->name('teacher/dashboard');
        Route::get('student/dashboard', 'studentDashboardIndex')->middleware('auth')->name('student/dashboard');
    });

    // ----------------------------- user controller ---------------------//
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('list/users', 'index')->middleware('auth')->name('list/users');
        Route::post('change/password', 'changePassword')->name('change/password');
        Route::get('view/user/edit/{id}', 'userView')->middleware('auth');
        Route::post('user/update', 'userUpdate')->name('user/update');
        Route::post('user/delete', 'userDelete')->name('user/delete');
        Route::get('get-users-data', 'getUsersData')->name('get-users-data'); /** get all data users */
    });

    // ------------------------ setting -------------------------------//
    Route::controller(Setting::class)->group(function () {
        Route::get('setting/page', 'index')->middleware('auth')->name('setting/page');
    });

    // ------------------------ student -------------------------------//
    Route::controller(StudentController::class)->group(function () {
        Route::get('student/list', 'student')->middleware('auth')->name('student/list'); // list student
        Route::get('student/grid', 'studentGrid')->middleware('auth')->name('student/grid'); // grid student
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
        Route::get('teacher/grid/page', 'teacherGrid')->middleware('auth')->name('teacher/grid/page'); // page grid teacher
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

    // ----------------------- department -----------------------------//
    Route::controller(DepartmentController::class)->group(function () {
        Route::get('department/list/page', 'departmentList')->middleware('auth')->name('department/list/page'); // department/list/page
        Route::get('department/add/page', 'indexDepartment')->middleware('auth')->name('department/add/page'); // page add department
        Route::get('department/edit/{department_id}', 'editDepartment'); // page add department
        Route::post('department/save', 'saveRecord')->middleware('auth')->name('department/save'); // department/save
        Route::post('department/update', 'updateRecord')->middleware('auth')->name('department/update'); // department/update
        Route::post('department/delete', 'deleteRecord')->middleware('auth')->name('department/delete'); // department/delete
        Route::get('get-data-list', 'getDataList')->name('get-data-list'); // get data list

    });

    // ----------------------- subject -----------------------------//
    Route::controller(SubjectController::class)->group(function () {
        Route::get('subject/list/page', 'subjectList')->middleware('auth')->name('subject/list/page'); // subject/list/page
        Route::get('subject/add/page', 'subjectAdd')->middleware('auth')->name('subject/add/page'); // subject/add/page
        Route::post('subject/save', 'saveRecord')->name('subject/save'); // subject/save
        Route::post('subject/update', 'updateRecord')->name('subject/update'); // subject/update
        Route::post('subject/delete', 'deleteRecord')->name('subject/delete'); // subject/delete
        Route::get('subject/edit/{subject_id}', 'subjectEdit'); // subject/edit/page
    });

    // ----------------------- invoice -----------------------------//
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('invoice/list/page', 'invoiceList')->middleware('auth')->name('invoice/list/page'); // subjeinvoicect/list/page
        Route::get('invoice/paid/page', 'invoicePaid')->middleware('auth')->name('invoice/paid/page'); // invoice/paid/page
        Route::get('invoice/overdue/page', 'invoiceOverdue')->middleware('auth')->name('invoice/overdue/page'); // invoice/overdue/page
        Route::get('invoice/draft/page', 'invoiceDraft')->middleware('auth')->name('invoice/draft/page'); // invoice/draft/page
        Route::get('invoice/recurring/page', 'invoiceRecurring')->middleware('auth')->name('invoice/recurring/page'); // invoice/recurring/page
        Route::get('invoice/cancelled/page', 'invoiceCancelled')->middleware('auth')->name('invoice/cancelled/page'); // invoice/cancelled/page
        Route::get('invoice/grid/page', 'invoiceGrid')->middleware('auth')->name('invoice/grid/page'); // invoice/grid/page
        Route::get('invoice/add/page', 'invoiceAdd')->middleware('auth')->name('invoice/add/page'); // invoice/add/page
        Route::post('invoice/add/save', 'saveRecord')->name('invoice/add/save'); // invoice/add/save
        Route::post('invoice/update/save', 'updateRecord')->name('invoice/update/save'); // invoice/update/save
        Route::post('invoice/delete', 'deleteRecord')->name('invoice/delete'); // invoice/delete
        Route::get('invoice/edit/{invoice_id}', 'invoiceEdit')->middleware('auth')->name('invoice/edit/page'); // invoice/edit/page
        Route::get('invoice/view/{invoice_id}', 'invoiceView')->middleware('auth')->name('invoice/view/page'); // invoice/view/page
        Route::get('invoice/settings/page', 'invoiceSettings')->middleware('auth')->name('invoice/settings/page'); // invoice/settings/page
        Route::get('invoice/settings/tax/page', 'invoiceSettingsTax')->middleware('auth')->name('invoice/settings/tax/page'); // invoice/settings/tax/page
        Route::get('invoice/settings/bank/page', 'invoiceSettingsBank')->middleware('auth')->name('invoice/settings/bank/page'); // invoice/settings/bank/page
    });

    // ----------------------- accounts ----------------------------//
    Route::controller(AccountsController::class)->group(function () {
        Route::get('account/fees/collections/page', 'index')->middleware('auth')->name('account/fees/collections/page'); // account/fees/collections/page
        Route::get('add/fees/collection/page', 'addFeesCollection')->middleware('auth')->name('add/fees/collection/page'); // add/fees/collection
        Route::post('fees/collection/save', 'saveRecord')->middleware('auth')->name('fees/collection/save'); // fees/collection/save
    });
});

// Route::get('/login', [LoginController::class, 'create'])
//     ->middleware('guest')
//     ->name('login');

// Route::post('/login', [LoginController::class, 'store'])
//     ->middleware('guest');

// Route::middleware(['auth', 'manager'])->group(function () {
//     Route::get('/my-info/{id}', [AuthController::class, 'myInfo'])->name('auth.my-info');
//     Route::PUT('/change-info/{id}', [AuthController::class, 'changeMyInfo'])->name('auth.change-info');

//     Route::get('/password/{id}', [AuthController::class, 'password'])->name('auth.password');
//     Route::PUT('/change-password/{id}', [AuthController::class, 'changeMyPassword'])->name('auth.change-my-password');

//     Route::resource('question', QuestionController::class);

//     Route::resource('homework', HomeworkController::class);

//     Route::resource('document', DocumentController::class);
//     Route::post('/document/upload', [DocumentController::class, 'uploadFile'])->name('document.upload');
//     Route::get('/document/download/{id}', [DocumentController::class, 'downloadFile'])->name('document.download');

//     Route::resource('/class', ClassController::class);

//     Route::get('/class-student/{id}', [StudentController::class, 'index'])->name('class_student.index');
//     Route::get('/class-student-detail/{class_id}-{student_id}', [StudentController::class, 'detail'])->name('class_student.detail');

//     Route::get('/class-lesson/{id}', [ClassLessonController::class, 'index'])->name('class_lesson.index');
//     Route::get('/class-lesson-create/{class_id}', [ClassLessonController::class, 'create'])->name('class_lesson.create');
//     Route::post('/class-lesson-store/{class_id}', [ClassLessonController::class, 'store'])->name('class_lesson.store');
//     Route::get('/class-lesson-show/{class_id}-{lesson_id}', [ClassLessonController::class, 'show'])->name('class_lesson.show');

//     Route::group(['prefix' => 'class_student'], function(){
//         Route::get('/{class_id}/{student_id}/', [StudentController::class, 'detail'])->name('class.student.detail');
//     });
//     // Route::get('/{class_id}/{student_id}', [StudentController::class, 'detail'])->name('class.student.detail');
//     // Route::get('/class/lesson/{class_id}/{lesson_id}', [AttendanceController::class, 'index'])->name('class.lesson.attendance.list');

//     Route::middleware('admin')->group(function () {
//         Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//         Route::resource('user', UserController::class);
//         Route::resource('teacher', TeacherController::class);
//         Route::resource('room', RoomController::class);

//     });

//     Route::middleware('teacher')->group(function () {
//         Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

//         Route::get('/calendar', [ScheduleController::class, 'index'])->name('calendar.index');
//     });
// });

// Route::post('/logout', [LoginController::class, 'destroy'])
//     ->middleware('auth')
//     ->name('logout');
