<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', [App\Http\Controllers\RootController::class, 'index'], function () {
    return view('root');
})->name('root');

Route::get('/cabinet',[App\Http\Controllers\CabinetController::class, 'index'], function () {
    return view('cabinet');
})->name('cabinet');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::post('vacancy-delete',  [App\Http\Controllers\VacancyController::class, 'delete'])->name('vacancy-delete');

Route::get('admin', [App\Http\Controllers\AdminController::class, 'index'], function () {
    return view('admin');
})->name('admin');

Route::post('vacancy-hide',  [App\Http\Controllers\AdminController::class, 'hideVacancy'])->name('vacancy-hide');

Route::get('post', [App\Http\Controllers\VacancyController::class, 'index'], function () {
    return view('post');
})->name('post');

Route::post('post', [App\Http\Controllers\VacancyController::class, 'postVacancy'], function () {
    return view('post');
})->name('vacancy-post');

Route::get('/vacancy/response/{id}', [App\Http\Controllers\VacancyController::class, 'getVanacyResponses'], function () {});

Route::post('vacancy-response',  [App\Http\Controllers\VacancyController::class, 'vacancyResponse'])->name('vacancy-response');

Route::get('/vacancy/edit/{id}', [App\Http\Controllers\VacancyController::class, 'getVanacy'], function () {})->name('edit-vacancy');
