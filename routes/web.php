<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
Auth::routes();

##Cabinet
Route::middleware(['auth'])->group(function () {
    Route::prefix('cabinet')->group(function () {
        Route::get('/',[App\Http\Controllers\CabinetController::class, 'index'])->name('cabinet');
        Route::prefix('resume')->group(function () {
            Route::get('/', [App\Http\Controllers\CabinetController::class, 'createResume']);
        });
        Route::get('invites', [App\Http\Controllers\CabinetController::class, 'invites']);

        Route::get('resume/{resume_id}', [App\Http\Controllers\CabinetController::class, 'getResume']);
        Route::get('vacancy', [App\Http\Controllers\VacancyController::class, 'index'])->name('post');
        Route::prefix('responses')->group(function () {
            Route::get('/', [App\Http\Controllers\CabinetController::class, 'getResposes'])->name('responses');
        });

        Route::prefix('vacancy')->group(function () {
            Route::prefix('view')->group(function () {
                Route::get('{id}', [App\Http\Controllers\VacancyController::class, 'viewVacancy'])->name('view-vacancy');
            });
        });

    });



    Route::get('post', [App\Http\Controllers\CabinetController::class, 'postPage'])->name('post');
    Route::get('/vacancy/response/{id}', [App\Http\Controllers\VacancyController::class, 'getVacancyResponses'], function () {});
    Route::get('/vacancy/edit/{id}', [App\Http\Controllers\VacancyController::class, 'getVacancy'], function () {})->name('edit-vacancy');

    Route::post('vacancy-hide',  [App\Http\Controllers\AdminController::class, 'hideVacancy'])->name('vacancy-hide');
});

Route::prefix('vacancy')->group(function () {
    Route::get('{id}', [App\Http\Controllers\VacancyController::class, 'showVacancy'])->name('show-vacancy');
});

// AJAX-запросы
Route::prefix('ajax')->group(function () {
    Route::post('vacancy-response',  [App\Http\Controllers\VacancyController::class, 'vacancyResponse'])->name('vacancy-response');
    Route::post('cancel-vacancy-response',  [App\Http\Controllers\VacancyController::class, 'cancelResponseVacancy'])->name('cancel-vacancy-response');
    Route::post('accept-vacancy-response',  [App\Http\Controllers\VacancyController::class, 'acceptResponseVacancy'])->name('accept-vacancy-response');
    Route::post('decline-vacancy-response',  [App\Http\Controllers\VacancyController::class, 'declineResponseVacancy'])->name('decline-vacancy-response');
    Route::post('post-vacancy', [App\Http\Controllers\VacancyController::class, 'postVacancy']);

    Route::post('vacancy-delete',  [App\Http\Controllers\VacancyController::class, 'delete'])->name('vacancy-delete');

    Route::post('filter-vacancies', [App\Http\Controllers\VacancyController::class, 'filterVacancies'], function () {});

    Route::prefix('vacancy')->group(function () {
        Route::get('get-candidates',  [App\Http\Controllers\VacancyController::class, 'getVacancyCandidates']);
        Route::post('invite-candidate',  [App\Http\Controllers\VacancyController::class, 'inviteVacancyCandidate']);
        Route::post('decline-candidate',  [App\Http\Controllers\VacancyController::class, 'declineVacancyCandidate']);
    });

    Route::prefix('resume')->group(function () {
        Route::post('post',  [App\Http\Controllers\CabinetController::class, 'publishResume']);
        Route::post('resume',  [App\Http\Controllers\ResumeController::class, 'deleteResume']);
        Route::get('get-resume',  [App\Http\Controllers\ResumeController::class, 'getResume']);
    });

    Route::prefix('project')->group(function () {
        Route::get('get', [App\Http\Controllers\ProjectsController::class, 'getProject']);
        Route::post('save', [App\Http\Controllers\ProjectsController::class, 'saveProject']);
        Route::get('get-list', [App\Http\Controllers\ProjectsController::class, 'getProjectsList']);
        Route::post('delete', [App\Http\Controllers\ProjectsController::class, 'deleteResumeProject']);
    });
});

Route::get('/', [App\Http\Controllers\RootController::class, 'index'], function () {
    return view('root');
})->name('root');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('admin', [App\Http\Controllers\AdminController::class, 'index'], function () {
    return view('admin');
})->name('admin');

Route::prefix('filter')->group(function () {
    Route::get('/city/{city_id}',[App\Http\Controllers\VacancyController::class, 'getVacancyByCity'], function () {});
    Route::get('/group/{group_id}',[App\Http\Controllers\VacancyController::class, 'getVacancyByGroup'], function () {});
});
