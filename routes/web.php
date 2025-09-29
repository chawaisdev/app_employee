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
    Route::get('login', [EmployeeLoginController::class, 'showLoginForm'])->name('login');      // Employee login form
    Route::post('login', [EmployeeLoginController::class, 'login'])->name('login.submit');     // Employee login submit
    Route::post('logout', [EmployeeLoginController::class, 'logout'])->name('logout');         // Employee logout
});

// Employee password update
Route::post('/update-password', [EmployeeLoginController::class, 'updatePassword'])->name('update.password');

/*
|--------------------------------------------------------------------------
| Client Routes (Accessible without login)
|--------------------------------------------------------------------------
*/
Route::get('/client/tasks/{id}', [ClientController::class, 'show'])->name('client.tasks.show');       // Show client tasks
Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');   // Client dashboard
Route::get('/client/task', [ClientController::class, 'clientTaskindex'])->name('client.tasklist');   // Client task list

/*
|--------------------------------------------------------------------------
| Employee Routes (Public accessible)
|--------------------------------------------------------------------------
*/
Route::get('/employee/tasklist', [EmployeeController::class, 'taskList'])->name('task.tasklist');    // Employee task list

/*
|--------------------------------------------------------------------------
| Project Assignment (Admin assigns projects)
|--------------------------------------------------------------------------
*/
Route::post('/client/{id}/assign-projects', [ClientController::class, 'assignProjects'])->name('client.assignProjects');          // Assign project to client
Route::post('/employees/{id}/assign-projects', [EmployeeController::class, 'assignProjects'])->name('employees.assignProjects');  // Assign project to employee

/*
|--------------------------------------------------------------------------
| Admin Dashboard (Protected by web guard)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');   // Admin dashboard
});

/*
|--------------------------------------------------------------------------
| Settings (Accessible without middleware for now)
|--------------------------------------------------------------------------
*/
Route::get('settings', [SettingController::class, 'index'])->name('settings.index');     // Show settings
Route::put('settings', [SettingController::class, 'update'])->name('settings.update');   // Update settings

/*
|--------------------------------------------------------------------------
| App Modules (Protected by web guard)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->group(function () {

    // Attendance (all records)
    Route::get('/attendance/all', [AttendanceController::class, 'attendanceall'])->name('dashboard');

    // Users
    Route::resource('adduser', AddUserController::class);

    // Clients
    Route::resource('client', ClientController::class);

    // Employees
    Route::resource('employees', EmployeeController::class);

    // Students
    Route::resource('students', StudentController::class);

    // Designations
    Route::resource('designation', DesignationController::class);

    // Projects
    Route::resource('project', ProjectController::class);
    Route::post('/project/{project}/assign', [ProjectController::class, 'assignEmployees'])->name('project.assign');

    // Notes
    Route::resource('notes', NotesController::class);
});

/*
|--------------------------------------------------------------------------
| Tasks (Accessible outside auth:web group)
|--------------------------------------------------------------------------
*/
Route::resource('tasks', TaskController::class);   // Task CRUD
Route::put('/tasks/{task}/{user}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');   // Update task status

/*
|--------------------------------------------------------------------------
| Attendance (Employee Guard Protected)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:employee')->group(function () {
    Route::controller(AttendanceController::class)->group(function () {
        Route::get('/attendance', 'index')->name('attendance.index');         // Attendance page
        Route::post('/attendance/checkin', 'checkIn')->name('attendance.checkin');   // Employee check-in
        Route::post('/attendance/checkout', 'checkOut')->name('attendance.checkout'); // Employee check-out
    });
});

/*
|--------------------------------------------------------------------------
| Add User (Duplicate resource route)
|--------------------------------------------------------------------------
*/
Route::resource('addusers', AddUserController::class);
