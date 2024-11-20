<?php

use App\Http\Controllers\AttemptController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmployeeController;
use App\Models\Attempt;
use App\Models\Employee;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index']);

Route::get('/access', [AttemptController::class, 'index']);

Route::get('/home', [EmployeeController::class, 'index']);

Route::get('/createemployee', [EmployeeController::class, 'showCreate']);

Route::get('/editemployee/{id}', [EmployeeController::class, 'showEdit']);

Route::get('/listattempts/{id}', [AttemptController::class, 'showAttempts']);