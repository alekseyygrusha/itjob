<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
Auth::routes();

##Cabinet
Route::prefix('cabinet')->group(function () {
    Route::get('/',[App\Http\Controllers\CabinetController::class, 'index'])->name('cabinet');
    Route::get('resume/{resume_id}', [App\Http\Controllers\CabinetController::class, 'getResume']);

    
});

Route::get('/', [App\Http\Controllers\RootController::class, 'index'], function () {
    return view('root');
})->name('root');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('admin', [App\Http\Controllers\AdminController::class, 'index'], function () {
    return view('admin');
})->name('admin');
Route::get('post', [App\Http\Controllers\VacancyController::class, 'index'], function () {
    return view('post');
})->name('post');
Route::get('/vacancy/response/{id}', [App\Http\Controllers\VacancyController::class, 'getVanacyResponses'], function () {});
Route::get('/vacancy/edit/{id}', [App\Http\Controllers\VacancyController::class, 'getVanacy'], function () {})->name('edit-vacancy');


Route::post('vacancy-delete',  [App\Http\Controllers\VacancyController::class, 'delete'])->name('vacancy-delete');
Route::post('vacancy-hide',  [App\Http\Controllers\AdminController::class, 'hideVacancy'])->name('vacancy-hide');
Route::post('post', [App\Http\Controllers\VacancyController::class, 'postVacancy'], function () {
    return view('post');
})->name('vacancy-post');
Route::post('vacancy-response',  [App\Http\Controllers\VacancyController::class, 'vacancyResponse'])->name('vacancy-response');
Route::post('resume-post',  [App\Http\Controllers\CabinetController::class, 'postResume'], function () {
    return view('cabinet');
})->name('resume-post');
Route::post('resume-delete',  [App\Http\Controllers\ResumeController::class, 'deleteResume'], function () {
    return view('cabinet');
})->name('resume-delete');



Route::prefix('filter')->group(function () {
    Route::get('/city/{city_id}',[App\Http\Controllers\VacancyController::class, 'getVanacyByCity'], function () {});
    Route::get('/group/{group_id}',[App\Http\Controllers\VacancyController::class, 'getVanacyByGroup'], function () {});
});