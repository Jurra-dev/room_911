<?php

use App\Http\Controllers\AttemptController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Models\Attempt;
use App\Models\Department;
use Illuminate\Support\Facades\Route;

Route::post('/send', [AttemptController::class, 'attemptAccess'])->name('access.send');

Route::post('/login', [LoginController::class, 'login'])->name('login.login');

Route::get('/getemployees', [EmployeeController::class, 'getEmployees'])->name('home.getemployees');

Route::get('/getdepartments', [DepartmentController::class, 'getAllDepartments'])->name('home.getdepartments');

Route::put('/changetype', [EmployeeController::class, 'changeType'])->name('home.changetype');

Route::post('/createemployee', [EmployeeController::class, 'createEmployee'])->name('employee.create');

Route::post('/editemployee', [EmployeeController::class, 'editEmployee'])->name('employee.edit');

Route::delete('/deleteemployee/{id}', [EmployeeController::class, 'deleteEmployee'])->name('employee.delete');

Route::get('/listattempts', [AttemptController::class, 'getAttempts'])->name('attempt.list');