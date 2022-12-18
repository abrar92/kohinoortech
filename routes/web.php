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
Route::post('/user_list/add_user', [UserController::class, 'add_user'])->name('add_user');
Route::post('/user_list/edit_user', [UserController::class, 'edit_user'])->name('edit_user');
Route::post('/user_list/delete_user', [UserController::class, 'delete_user'])->name('delete_user');
Route::get('/user_list/get_user_company', [UserController::class, 'get_user_company'])->name('get_user_company');

Route::get('/company_list', [CompanyController::class, 'company_list'] );
Route::post('/company_list/modify_user', [CompanyController::class, 'modify_user'])->name('modify_user');
Route::post('/company_list/add_company', [CompanyController::class, 'add_company'])->name('add_company');
Route::post('/company_list/edit_company', [CompanyController::class, 'edit_company'])->name('edit_company');
Route::post('/company_list/delete_company', [CompanyController::class, 'delete_company'])->name('delete_company');
Route::get('/company_list/get_company_user', [CompanyController::class, 'get_company_user'])->name('get_company_user');

Route::resource('/matrix', 'App\Http\Controllers\MatrixController'); // This is a Resource Controller.