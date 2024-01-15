@extends('layouts.app')

@section('content')
    <div class="vacancy-card">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="info-box">
                        <div class="content">
                            <div class="content-item -title">{{$vacancy->job_title}}</div>
                            <div class="content-item -salary">
                                @if(!empty($vacancy->min_salary) && $vacancy->min_salary !== 0 && !empty($vacancy->max_salary) && $vacancy->max_salary !== 0)
                                    от {{$vacancy->min_salary}} до {{$vacancy->max_salary}} ₽
                                @elseif(!empty($vacancy->max_salary) && $vacancy->max_salary !== 0)
                                    до {{$vacancy->max_salary}} ₽
                                @elseif(!empty($vacancy->min_salary) && $vacancy->min_salary !== 0)
                                    от {{$vacancy->min_salary}}
                                @else
                                @endif
                            </div>
                            <div class="content-item -exp">Опыт работы: {{$vacancy->experience->text}}</div>
                            <div class="content-item -company">{{$vacancy->company_name}}</div>
                            <div class="content-item -city">{{$vacancy->bindCity->name}}</div>
                        </div>
                    </div>
                    <div class="main-description">
                        <div class="row">
                            <div class="col-4">
                                <div class="info-box description-block">
                                    <div class="block-heading">Технологии</div>
                                    <div class="skills-box">
                                        @foreach($vacancy->skills as $skill)
                                            <div class="skills-box-item">{{$skill->name}}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="buttons-wrap vue-response-vacancy">
                                    @if(Auth::user())
                                        <response-vacancy
                                            resume_list="{{$resume_list->getContent()}}"
                                            id="{{$vacancy->id}}"
                                            responsed_id="@if(!empty($vacancy->vacancyResponses)){{$vacancy->vacancyResponses->resume_id}}@endif"
                                        >
                                        </response-vacancy>
                                    @else
                                        <div class="info-box block-to-login">
                                            <div class="login-text mb-2">Для отклика на вакансию требуется авторизация</div>
                                            <a class="link-to-login button-st -transparent" href="/login/">Войти</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="info-box description-block">
                                    <div class="block-heading">Описание вакансии</div>
                                    <div class="description">
                                        {!! $vacancy->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
