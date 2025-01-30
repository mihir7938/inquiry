<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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

Route::get('/', [AuthController::class, 'getLogin'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::group(['prefix' => 'password'], function () {
    Route::get('/forget', [AuthController::class, 'forgetPassword'])->name('forget_password');
    Route::post('/reset', [AuthController::class, 'resetPassword'])->name('check_password_reset');
    Route::get('/reset/{token}', [AuthController::class, 'getChangePassword'])->name('reset_password_link');
    Route::post('/reset/new/{token}', [AuthController::class, 'postChangePassword'])->name('change_password');
});

Route::group(['prefix' => 'office', 'middleware' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/cities', [AdminController::class, 'cities'])->name('admin.cities');
    Route::get('/cities/add', [AdminController::class, 'addCity'])->name('admin.cities.add');
    Route::post('/cities/save', [AdminController::class, 'saveCity'])->name('admin.cities.add.save');
    Route::get('/cities/edit/{id}', [AdminController::class, 'editCity'])->name('admin.cities.edit');
    Route::post('/cities/update', [AdminController::class, 'updateCity'])->name('admin.cities.update.save');
    Route::get('/cities/delete/{id}', [AdminController::class, 'deleteCity'])->name('admin.cities.delete');
    Route::get('/business', [AdminController::class, 'business'])->name('admin.business');
    Route::get('/business/add', [AdminController::class, 'addBusiness'])->name('admin.business.add');
    Route::post('/business/save', [AdminController::class, 'saveBusiness'])->name('admin.business.add.save');
    Route::get('/business/edit/{id}', [AdminController::class, 'editBusiness'])->name('admin.business.edit');
    Route::post('/business/update', [AdminController::class, 'updateBusiness'])->name('admin.business.update.save');
    Route::get('/business/delete/{id}', [AdminController::class, 'deleteBusiness'])->name('admin.business.delete');
    Route::get('/requirements', [AdminController::class, 'requirements'])->name('admin.requirements');
    Route::get('/requirements/add', [AdminController::class, 'addRequirement'])->name('admin.requirements.add');
    Route::post('/requirements/save', [AdminController::class, 'saveRequirement'])->name('admin.requirements.add.save');
    Route::get('/requirements/edit/{id}', [AdminController::class, 'editRequirement'])->name('admin.requirements.edit');
    Route::post('/requirements/update', [AdminController::class, 'updateRequirement'])->name('admin.requirements.update.save');
    Route::get('/requirements/delete/{id}', [AdminController::class, 'deleteRequirement'])->name('admin.requirements.delete');
    Route::get('/status', [AdminController::class, 'status'])->name('admin.status');
    Route::get('/status/add', [AdminController::class, 'addStatus'])->name('admin.status.add');
    Route::post('/status/save', [AdminController::class, 'saveStatus'])->name('admin.status.add.save');
    Route::get('/status/edit/{id}', [AdminController::class, 'editStatus'])->name('admin.status.edit');
    Route::post('/status/update', [AdminController::class, 'updateStatus'])->name('admin.status.update.save');
    Route::get('/status/delete/{id}', [AdminController::class, 'deleteStatus'])->name('admin.status.delete');
    Route::get('/assign', [AdminController::class, 'assign'])->name('admin.assign');
    Route::get('/assign/add', [AdminController::class, 'addAssign'])->name('admin.assign.add');
    Route::post('/assign/save', [AdminController::class, 'saveAssign'])->name('admin.assign.add.save');
    Route::get('/assign/edit/{id}', [AdminController::class, 'editAssign'])->name('admin.assign.edit');
    Route::post('/assign/update', [AdminController::class, 'updateAssign'])->name('admin.assign.update.save');
    Route::get('/assign/delete/{id}', [AdminController::class, 'deleteAssign'])->name('admin.assign.delete');
    Route::get('/users', [AdminController::class, 'getUsers'])->name('admin.users');
    Route::get('/users/add', [AdminController::class, 'addUser'])->name('admin.users.add');
    Route::post('/users/save', [AdminController::class, 'saveUser'])->name('admin.users.add.save');
    Route::get('/users/edit/{id}', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/users/update', [AdminController::class, 'updateUser'])->name('admin.users.update.save');
    Route::get('/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/inquiries', [AdminController::class, 'getInquiries'])->name('admin.inquiries');
});

Route::group(['prefix' => 'users', 'middleware' => 'user'], function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/', [UserController::class, 'saveInquiry'])->name('users.inquiry.save');
});