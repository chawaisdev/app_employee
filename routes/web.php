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
    ClientController,
    DashboardController
};

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('auth.login'))->name('home');

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
    Route::post('/update-password', [EmployeeLoginController::class, 'updatePassword'])->name('update.password');

});
Route::get('/client/tasks/{id}', [ClientController::class, 'show'])->name('client.tasks.show');

/*
|--------------------------------------------------------------------------
| Admin Authentication (Default auth: users)
|--------------------------------------------------------------------------
*/

   Route::middleware('auth:web')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

 // Employee settings
// Route::middleware(['auth'])->group(function () {
   Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

// });
/*
|--------------------------------------------------------------------------
| App Modules (Protected by default auth: web)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->group(function () {

    //All Attendance
    Route::get('/attendance/all', [AttendanceController::class, 'attendanceall'])->name('dashboard');
    // Users
    Route::resource('adduser', AddUserController::class);

    // Employees
    Route::resource('employees', EmployeeController::class);

    // Students
    Route::resource('students', StudentController::class);

    // Designations
    Route::resource('designation', DesignationController::class);

    // Projects
    Route::resource('project', ProjectController::class);
    Route::post('/project/{project}/assign', [ProjectController::class, 'assignEmployees'])->name('project.assign');


    // Settings

    // Notes
    Route::resource('notes', NotesController::class);


});
    Route::get('/client/tasks', [ClientController::class, 'index'])->name('client.tasks.index');

    // Tasks
    Route::resource('tasks', TaskController::class);
    Route::put('/tasks/{task}/{user}/status', [TaskController::class, 'updateStatus'])
        ->name('tasks.updateStatus');
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
