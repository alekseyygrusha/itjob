<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
Auth::routes();

##Cabinet
Route::prefix('cabinet')->group(function () {
    Route::get('/',[App\Http\Controllers\CabinetController::class, 'index'])->name('cabinet');
    Route::prefix('resume')->group(function () {
        Route::get('/', [App\Http\Controllers\CabinetController::class, 'createResume']);
    });

    Route::get('resume/{resume_id}', [App\Http\Controllers\CabinetController::class, 'getResume']);
    Route::get('vacancy', [App\Http\Controllers\VacancyController::class, 'index'])->name('post');
    Route::prefix('responses')->group(function () {
        Route::get('/', [App\Http\Controllers\CabinetController::class, 'getResposes'])->name('responses');
    });


});

// AJAX-запросы
Route::prefix('ajax')->group(function () {
    Route::post('vacancy-response',  [App\Http\Controllers\VacancyController::class, 'vacancyResponse'])->name('vacancy-response');
    Route::post('cancel-vacancy-response',  [App\Http\Controllers\VacancyController::class, 'cancelResponseVacancy'])->name('cancel-vacancy-response');
    Route::post('accept-vacancy-response',  [App\Http\Controllers\VacancyController::class, 'acceptResponseVacancy'])->name('accept-vacancy-response');
    Route::post('decline-vacancy-response',  [App\Http\Controllers\VacancyController::class, 'declineResponseVacancy'])->name('decline-vacancy-response');
    Route::post('post-vacancy', [App\Http\Controllers\VacancyController::class, 'postVacancy']);
    Route::post('post-resume',  [App\Http\Controllers\CabinetController::class, 'publishResume'], function () {
    })->name('resume-post');
    Route::post('vacancy-delete',  [App\Http\Controllers\VacancyController::class, 'delete'])->name('vacancy-delete');

    Route::post('resume-delete',  [App\Http\Controllers\ResumeController::class, 'deleteResume'])->name('resume-delete');
    Route::post('filter-vacancies', [App\Http\Controllers\VacancyController::class, 'filterVacancies'], function () {});
});

Route::get('/', [App\Http\Controllers\RootController::class, 'index'], function () {
    return view('root');
})->name('root');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('admin', [App\Http\Controllers\AdminController::class, 'index'], function () {
    return view('admin');
})->name('admin');
Route::get('post', [App\Http\Controllers\CabinetController::class, 'postPage'])->name('post');
Route::get('/vacancy/response/{id}', [App\Http\Controllers\VacancyController::class, 'getVanacyResponses'], function () {});
Route::get('/vacancy/edit/{id}', [App\Http\Controllers\VacancyController::class, 'getVanacy'], function () {})->name('edit-vacancy');

Route::post('vacancy-hide',  [App\Http\Controllers\AdminController::class, 'hideVacancy'])->name('vacancy-hide');




Route::prefix('filter')->group(function () {
    Route::get('/city/{city_id}',[App\Http\Controllers\VacancyController::class, 'getVanacyByCity'], function () {});
    Route::get('/group/{group_id}',[App\Http\Controllers\VacancyController::class, 'getVanacyByGroup'], function () {});
});
