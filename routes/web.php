<?php
use App\Http\Controllers\AddUserController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;


Route::put('/tasks/{task}/{user}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

Route::resource('adduser', AddUserController::class);
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance/checkin', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
Route::post('/attendance/checkout', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
// Designation CRUD
Route::resource('designation', DesignationController::class);
Route::resource('project', ProjectController::class);
Route::resource('settings', SettingController::class);

// Users CRUD
Route::resource('users', UserController::class);

// Attendance CRUD
Route::resource('attendance', AttendanceController::class);

// Notes CRUD
Route::resource('notes', NotesController::class);

// Tasks CRUD
Route::resource('tasks', TaskController::class);

// Employee CRUD
Route::resource('employees', EmployeeController::class);
Route::resource('students', StudentController::class);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});
