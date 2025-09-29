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
| Client Routes (Protected by client guard)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web', 'client'])->group(function () {
    Route::get('/client/tasks/{id}', [ClientController::class, 'show'])->name('client.tasks.show');     // Show client tasks
    Route::get('/client/task', [ClientController::class, 'clientTaskindex'])->name('client.tasklist'); // Client task list
    Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard'); // Client dashboard
});

/*
|--------------------------------------------------------------------------
| Employee Routes (Protected by employee guard)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:employee', 'employee'])->group(function () {
    Route::get('/employee/tasklist', [EmployeeController::class, 'taskList'])->name('task.tasklist');  // Employee task list

    // Attendance (employee self)
    Route::controller(AttendanceController::class)->group(function () {
        Route::get('/attendance', 'index')->name('attendance.index');           // Attendance page
        Route::post('/attendance/checkin', 'checkIn')->name('attendance.checkin');   // Employee check-in
        Route::post('/attendance/checkout', 'checkOut')->name('attendance.checkout'); // Employee check-out
    });
});

/*
|--------------------------------------------------------------------------
| Project Assignment
|--------------------------------------------------------------------------
*/
Route::post('/client/{id}/assign-projects', [ClientController::class, 'assignProjects'])->name('client.assignProjects');
Route::post('/employees/{id}/assign-projects', [EmployeeController::class, 'assignProjects'])->name('employees.assignProjects');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected by web guard + admin middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web', 'admin'])->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Attendance (all records)
    Route::get('/attendance/all', [AttendanceController::class, 'attendanceall'])->name('attendance.all');

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');     // Show settings
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');   // Update settings

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
| Tasks (accessible by both admins and employees if needed)
|--------------------------------------------------------------------------
*/
Route::resource('tasks', TaskController::class)
    ->middleware(['auth:web', 'admin']); // ✅ admin-only by default

// اگر آپ چاہتے ہیں کہ employees بھی tasks manage کر سکیں تو یہ extra route استعمال کریں
// Route::resource('employee/tasks', TaskController::class)->middleware(['auth:employee', 'employee']);
