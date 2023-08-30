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
    Route::get('/lock', 'App\Http\Controllers\HomeController@lock')->name('lock');
    Route::get('/data', 'App\Http\Controllers\HomeController@data')->name('data');
    Route::get('/stat', 'App\Http\Controllers\HomeController@stat')->name('stat');
    Route::post('/unlock', 'App\Http\Controllers\HomeController@unlock')->name('unlock');
    Route::post('/student-attendances', 'App\Http\Controllers\StudentAttendanceController@store')->name('student-attendances.store');

    Route::middleware(['lock'])->group(function () {
        Route::middleware(['admin'])->group(function () {
            Route::get('/teachers', 'App\Http\Controllers\TeacherController@index')->name('teachers.index');
            Route::get('/teachers/create', 'App\Http\Controllers\TeacherController@create')->name('teachers.create');
            Route::get('/teachers/{id}', 'App\Http\Controllers\TeacherController@destroy')->name('teachers.destroy');
            Route::get('/teachers/{id}/edit', 'App\Http\Controllers\TeacherController@edit')->name('teachers.edit');
            Route::post('/teachers/store', 'App\Http\Controllers\TeacherController@store')->name('teachers.store');
            Route::put('/teachers/{id}', 'App\Http\Controllers\TeacherController@update')->name('teachers.update');

            Route::get('/attendances/create', 'App\Http\Controllers\AttendanceController@create')->name('attendances.create');
            Route::delete('/attendances/{id}', 'App\Http\Controllers\AttendanceController@destroy')->name('attendances.destroy');
            Route::get('/attendances/{id}/edit', 'App\Http\Controllers\AttendanceController@edit')->name('attendances.edit');
            Route::post('/attendances/store', 'App\Http\Controllers\AttendanceController@store')->name('attendances.store');
            Route::put('/attendances/{id}', 'App\Http\Controllers\AttendanceController@update')->name('attendances.update');

            Route::get('/periods', 'App\Http\Controllers\PeriodController@index')->name('periods.index');
            Route::get('/periods/create', 'App\Http\Controllers\PeriodController@create')->name('periods.create');
            Route::delete('/periods/{id}', 'App\Http\Controllers\PeriodController@destroy')->name('periods.destroy');
            Route::get('/periods/{id}/edit', 'App\Http\Controllers\PeriodController@edit')->name('periods.edit');
            Route::post('/periods/store', 'App\Http\Controllers\PeriodController@store')->name('periods.store');
            Route::put('/periods/{id}', 'App\Http\Controllers\PeriodController@update')->name('periods.update');
            Route::get('/periods/{id}', 'App\Http\Controllers\PeriodController@show')->name('periods.show');

            Route::get('/schoolyears', 'App\Http\Controllers\SchoolYearController@index')->name('schoolyears.index');
            Route::get('/schoolyears/create', 'App\Http\Controllers\SchoolYearController@create')->name('schoolyears.create');
            Route::delete('/schoolyears/{id}', 'App\Http\Controllers\SchoolYearController@destroy')->name('schoolyears.destroy');
            Route::get('/schoolyears/{id}/edit', 'App\Http\Controllers\SchoolYearController@edit')->name('schoolyears.edit');
            Route::post('/schoolyears/store', 'App\Http\Controllers\SchoolYearController@store')->name('schoolyears.store');
            Route::put('/schoolyears/{id}', 'App\Http\Controllers\SchoolYearController@update')->name('schoolyears.update');
            Route::get('/schoolyears/{id}', 'App\Http\Controllers\SchoolYearController@show')->name('schoolyears.show');

            Route::get('/classrooms', 'App\Http\Controllers\ClassroomController@index')->name('classrooms.index');
            Route::get('/classrooms/year/{id}', 'App\Http\Controllers\ClassroomController@year')->name('classrooms.year');
            Route::get('/classrooms/create/{id}', 'App\Http\Controllers\ClassroomController@create')->name('classrooms.create');
            Route::post('/classrooms/store', 'App\Http\Controllers\ClassroomController@store')->name('classrooms.store');
            Route::get('/classrooms/{id}', 'App\Http\Controllers\ClassroomController@show')->name('classrooms.show');
            Route::get('/classrooms/{id}/edit', 'App\Http\Controllers\ClassroomController@edit')->name('classrooms.edit');
            Route::put('/classrooms/{id}', 'App\Http\Controllers\ClassroomController@update')->name('classrooms.update');
            Route::delete('/classrooms/{id}', 'App\Http\Controllers\ClassroomController@destroy')->name('classrooms.destroy');
            Route::post('/classrooms/student/{id}', 'App\Http\Controllers\ClassroomController@addStudent')->name('classrooms.addStudent');
            Route::get('/classrooms/student/{id}', 'App\Http\Controllers\ClassroomController@destroyStudent')->name('classrooms.destroyStudent');

            Route::get('/holidays/year/{id}', 'App\Http\Controllers\HolidayController@year')->name('holidays.year');
            Route::get('/holidays/create/{id}', 'App\Http\Controllers\HolidayController@create')->name('holidays.create');
            Route::post('/holidays/store', 'App\Http\Controllers\HolidayController@store')->name('holidays.store');
            Route::get('/holidays/{id}', 'App\Http\Controllers\HolidayController@show')->name('holidays.show');
            Route::get('/holidays/{id}/edit', 'App\Http\Controllers\HolidayController@edit')->name('holidays.edit');
            Route::put('/holidays/{id}', 'App\Http\Controllers\HolidayController@update')->name('holidays.update');
            Route::delete('/holidays/{id}', 'App\Http\Controllers\HolidayController@destroy')->name('holidays.destroy');

            Route::get('/students', 'App\Http\Controllers\StudentController@index')->name('students.index');
            Route::get('/students/create', 'App\Http\Controllers\StudentController@create')->name('students.create');
            Route::get('/students/{id}', 'App\Http\Controllers\StudentController@destroy')->name('students.destroy');
            Route::get('/students/{id}/edit', 'App\Http\Controllers\StudentController@edit')->name('students.edit');
            Route::post('/students/store', 'App\Http\Controllers\StudentController@store')->name('students.store');
            Route::put('/students/{id}', 'App\Http\Controllers\StudentController@update')->name('students.update');
        });

        Route::get('/', 'App\Http\Controllers\HomeController@index')->name('index');
        Route::get('/shownotification/{id}', 'App\Http\Controllers\HomeController@showNotification')->name('show.notification');
        Route::post('/sendnotification', 'App\Http\Controllers\HomeController@sendNotification')->name('send.notification');
        
        Route::get('/password-reset/{id}', 'App\Http\Controllers\PasswordController@index')->name('reset.index');
        Route::post('/password-reset', 'App\Http\Controllers\PasswordController@resetPassword')->name('reset.password');

        Route::get('/password-change', 'App\Http\Controllers\PasswordController@edit')->name('change.edit');
        Route::post('/password-change', 'App\Http\Controllers\PasswordController@changePassword')->name('change.password');

        Route::get('/leaves', 'App\Http\Controllers\LeaveController@index')->name('leaves.index');
        Route::get('/leaves/create', 'App\Http\Controllers\LeaveController@create')->name('leaves.create');
        Route::post('/leaves/store', 'App\Http\Controllers\LeaveController@store')->name('leaves.store');
        Route::get('/leaves/{id}/edit', 'App\Http\Controllers\LeaveController@edit')->name('leaves.edit');
        Route::get('/leaves/{id}', 'App\Http\Controllers\LeaveController@show')->name('leaves.show');
        Route::put('/leaves/{id}', 'App\Http\Controllers\LeaveController@update')->name('leaves.update');
        Route::delete('/leaves/{id}', 'App\Http\Controllers\LeaveController@destroy')->name('leaves.destroy');
        
        Route::get('/attendances', 'App\Http\Controllers\AttendanceController@index')->name('attendances.index');
        Route::patch('/attendances/{id}', 'App\Http\Controllers\AttendanceController@statusUpdate')->name('attendances.status.update');
        Route::get('/attendances/{id}', 'App\Http\Controllers\AttendanceController@show')->name('attendances.show');
        Route::get('/attendances/{id}/classroom/{classroom_id}', 'App\Http\Controllers\AttendanceController@showClass')->name('attendances.class');
        Route::patch('/student-attendances/{id}', 'App\Http\Controllers\StudentAttendanceController@update')->name('student-attendances.update');

        Route::get('/recapitulations', 'App\Http\Controllers\RecapitulationController@index')->name('recapitulations.index');
        Route::get('/recapitulations/{id}', 'App\Http\Controllers\RecapitulationController@show')->name('recapitulations.show');
        Route::get('/recapitulations/{id}/classroom/{classroom_id}', 'App\Http\Controllers\RecapitulationController@showClass')->name('recapitulations.class.show');
        Route::get('/recapitulations/{id}/month/{month}/classroom/{classroom_id}', 'App\Http\Controllers\RecapitulationController@monthClass')->name('recapitulations.class.month');
        Route::get('/recapitulations/{id}/month/{month}', 'App\Http\Controllers\RecapitulationController@month')->name('recapitulations.month');
        Route::get('/print/{id}/classroom/{classroom_id}', 'App\Http\Controllers\RecapitulationController@print')->name('recapitulations.print');
        Route::get('/print/{id}/month/{month}/classroom/{classroom_id}', 'App\Http\Controllers\RecapitulationController@printMonth')->name('recapitulations.print.month');
        Route::get('/qrprint/{id}', 'App\Http\Controllers\HomeController@qrprint')->name('qrprint');
    });
});