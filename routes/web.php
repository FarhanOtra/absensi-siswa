<?php

use Illuminate\Support\Facades\Route;

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

/* Route::get('/', function () {
    return view('welcome');
}); */


Route::middleware(['auth','no-student'])->group(function () {
    Route::get('/', 'App\Http\Controllers\HomeController@index')->name('index');
    Route::get('/data', 'App\Http\Controllers\HomeController@data')->name('data');
    Route::get('/stat', 'App\Http\Controllers\HomeController@stat')->name('stat');
    
    Route::get('/password-reset/{id}', 'App\Http\Controllers\PasswordController@index')->name('reset.index');
    Route::post('/password-reset', 'App\Http\Controllers\PasswordController@resetPassword')->name('reset.password');

    Route::get('/password-change', 'App\Http\Controllers\PasswordController@edit')->name('change.edit');
    Route::post('/password-change', 'App\Http\Controllers\PasswordController@changePassword')->name('change.password');

    Route::middleware(['admin'])->group(function () {
        Route::get('/teachers', 'App\Http\Controllers\TeacherController@index')->name('teachers.index');
        Route::get('/teachers/create', 'App\Http\Controllers\TeacherController@create')->name('teachers.create');
        Route::get('/teachers/{id}', 'App\Http\Controllers\TeacherController@destroy')->name('teachers.destroy');
        Route::get('/teachers/{id}/edit', 'App\Http\Controllers\TeacherController@edit')->name('teachers.edit');
        Route::post('/teachers/store', 'App\Http\Controllers\TeacherController@store')->name('teachers.store');
        Route::put('/teachers/{id}', 'App\Http\Controllers\TeacherController@update')->name('teachers.update');

        Route::get('/periods', 'App\Http\Controllers\PeriodController@index')->name('periods.index');
        Route::get('/periods/create', 'App\Http\Controllers\PeriodController@create')->name('periods.create');
        Route::delete('/periods/{id}', 'App\Http\Controllers\PeriodController@destroy')->name('periods.destroy');
        Route::get('/periods/{id}/edit', 'App\Http\Controllers\PeriodController@edit')->name('periods.edit');
        Route::post('/periods/store', 'App\Http\Controllers\PeriodController@store')->name('periods.store');
        Route::put('/periods/{id}', 'App\Http\Controllers\PeriodController@update')->name('periods.update');
        Route::get('/periods/{id}', 'App\Http\Controllers\PeriodController@show')->name('periods.show');
        Route::get('/periods/{id}/month/{month}', 'App\Http\Controllers\PeriodController@month')->name('periods.month');
        Route::get('/print/{id}/classroom/{classroom_id}', 'App\Http\Controllers\PeriodController@print')->name('periods.print');
        Route::get('/print/{id}/month/{month}/classroom/{classroom_id}', 'App\Http\Controllers\PeriodController@printMonth')->name('periods.print.month');

        Route::get('/attendances', 'App\Http\Controllers\AttendanceController@index')->name('attendances.index');
        Route::get('/attendances/create', 'App\Http\Controllers\AttendanceController@create')->name('attendances.create');
        Route::delete('/attendances/{id}', 'App\Http\Controllers\AttendanceController@destroy')->name('attendances.destroy');
        Route::get('/attendances/{id}/edit', 'App\Http\Controllers\AttendanceController@edit')->name('attendances.edit');
        Route::post('/attendances/store', 'App\Http\Controllers\AttendanceController@store')->name('attendances.store');
        Route::put('/attendances/{id}', 'App\Http\Controllers\AttendanceController@update')->name('attendances.update');
        Route::patch('/attendances/{id}', 'App\Http\Controllers\AttendanceController@statusUpdate')->name('attendances.status.update');
        Route::get('/attendances/{id}', 'App\Http\Controllers\AttendanceController@show')->name('attendances.show');

        Route::patch('/student-attendances/{id}', 'App\Http\Controllers\StudentAttendanceController@update')->name('student-attendances.update');

    });

    Route::get('/students', 'App\Http\Controllers\StudentController@index')->name('students.index');
    Route::get('/students/create', 'App\Http\Controllers\StudentController@create')->name('students.create');
    Route::get('/students/{id}', 'App\Http\Controllers\StudentController@destroy')->name('students.destroy');
    Route::get('/students/{id}/edit', 'App\Http\Controllers\StudentController@edit')->name('students.edit');
    Route::post('/students/store', 'App\Http\Controllers\StudentController@store')->name('students.store');
    Route::put('/students/{id}', 'App\Http\Controllers\StudentController@update')->name('students.update');

    Route::get('/classrooms', 'App\Http\Controllers\ClassroomController@index')->name('classrooms.index');
    Route::get('/classrooms/create', 'App\Http\Controllers\ClassroomController@create')->name('classrooms.create');
    Route::post('/classrooms/store', 'App\Http\Controllers\ClassroomController@store')->name('classrooms.store');
    Route::get('/classrooms/{id}', 'App\Http\Controllers\ClassroomController@show')->name('classrooms.show');
    Route::get('/classrooms/{id}/edit', 'App\Http\Controllers\ClassroomController@edit')->name('classrooms.edit');
    Route::put('/classrooms/{id}', 'App\Http\Controllers\ClassroomController@update')->name('classrooms.update');
    Route::delete('/classrooms/{id}', 'App\Http\Controllers\ClassroomController@destroy')->name('classrooms.destroy');
    Route::post('/classrooms/student/{id}', 'App\Http\Controllers\ClassroomController@addStudent')->name('classrooms.addStudent');
    Route::get('/classrooms/student/{id}', 'App\Http\Controllers\ClassroomController@destroyStudent')->name('classrooms.destroyStudent');

    Route::get('/permissions', 'App\Http\Controllers\PermissionController@index')->name('permissions.index');
    Route::get('/permissions/create', 'App\Http\Controllers\PermissionController@create')->name('permissions.create');
    Route::post('/permissions/store', 'App\Http\Controllers\PermissionController@store')->name('permissions.store');
    Route::get('/permissions/{id}/edit', 'App\Http\Controllers\PermissionController@edit')->name('permissions.edit');
    Route::put('/permissions/{id}', 'App\Http\Controllers\PermissionController@update')->name('permissions.update');
    Route::delete('/permissions/{id}', 'App\Http\Controllers\PermissionController@destroy')->name('permissions.destroy');
});
