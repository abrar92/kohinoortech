<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MatrixController;

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

Route::get('/user_list', [UserController::class, 'user_list'] );

Route::get('/company_list', [CompanyController::class, 'company_list'] );
Route::post('/company_list/modify_user', [CompanyController::class, 'modify_user'])->name('modify_user');
Route::post('/company_list/add_company', [CompanyController::class, 'add_company'])->name('add_company');
Route::post('/company_list/delete_company', [CompanyController::class, 'delete_company'])->name('delete_company');

Route::resource('matrix', 'App\Http\Controllers\MatrixController'); // This is a Resource Controller.