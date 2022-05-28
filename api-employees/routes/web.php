<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
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

Route::get('/', function () {
    return view('welcome');
});


// Rutas de la API

Route::get('/api/employee/index', [EmployeeController::class, 'index']);
Route::get('/api/employee/{id}', [EmployeeController::class, 'get_employee']);
Route::get('/api/employee/search/{find}', [EmployeeController::class, 'search']);
Route::post('/api/employee/create', [EmployeeController::class, 'create']);
Route::get('/api/employee/delete_employee/{id}', [EmployeeController::class, 'delete_employee']);
Route::post('/api/employee/update', [EmployeeController::class, 'update']);
Route::get('/api/employee/delete_selected/{ids}', [EmployeeController::class, 'delete_selected']);