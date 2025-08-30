<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AddUserController,
    DesignationController,
    AttendanceController,
    ProjectController,
    NotesController,
    TaskController,
    SettingController,
    LeaveController,
    EmployeeController,
    StudentController,
    Auth\EmployeeLoginController,
    UserController,
    DashboardController
};

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('home');

/*
|--------------------------------------------------------------------------
| Employee Authentication (Custom Guard: employee)
|--------------------------------------------------------------------------
*/
Route::prefix('employee')->name('employee.')->group(function () {
    Route::get('login', [EmployeeLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [EmployeeLoginController::class, 'login'])->name('login.submit');
    Route::post('logout', [EmployeeLoginController::class, 'logout'])->name('logout');
});

// Employee dashboard (protected with employee guard)
Route::middleware('auth:employee')->group(function () {
    Route::get('/employee/dashboard', function () {
        $employee = Auth::guard('employee')->user();
        return view('employees.dashboard', compact('employee'));
    })->name('employee.dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Authentication (Default auth: users)
|--------------------------------------------------------------------------
*/

   Route::middleware('auth:web')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| App Modules (Protected by default auth: web)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->group(function () {

    //All Attendance
    Route::get('/attendance/all', [AttendanceController::class, 'attendanceall'])->name('dashboard');
    // Users
    Route::resource('users', UserController::class);

    // Employees
    Route::resource('employees', EmployeeController::class);

    // Students
    Route::resource('students', StudentController::class);

    // Designations
    Route::resource('designation', DesignationController::class);

    // Projects
    Route::resource('project', ProjectController::class);

    // Settings
    Route::resource('settings', SettingController::class);

    // Notes
    Route::resource('notes', NotesController::class);

    // Tasks
    Route::resource('tasks', TaskController::class);
    Route::put('/tasks/{task}/{user}/status', [TaskController::class, 'updateStatus'])
        ->name('tasks.updateStatus');
});

// Attendance
Route::middleware('auth:employee')->group(function () {
    Route::controller(AttendanceController::class)->group(function () {
        Route::get('/attendance', 'index')->name('attendance.index');
        Route::post('/attendance/checkin', 'checkIn')->name('attendance.checkin');
        Route::post('/attendance/checkout', 'checkOut')->name('attendance.checkout');
    });
});

// Add User
Route::resource('addusers', AddUserController::class);
