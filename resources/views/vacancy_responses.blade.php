<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Отклики</title>
        @include('templates.blocks.meta')
    </head>
    <body>
        @include('templates.blocks.header');
        <div class="container" id="app">
            <h3>Отклики на вакансию <span style="color: #59b999">{{$vacancy->job_title}}</span></h3>
            <p style="border-bottom: 1px solid #59b999">{{$vacancy->description}}</p>
            <div class="users-list">
                <div class="resume-wrap">
                    <div class="vacancies-container">
                        @if(!empty($vacancy_responses) && count($vacancy_responses) > 1)
                            @foreach($vacancy_responses as $response)
                                <div class="vacancies-card vue-response-resume">
                                    <div class="name"><b>Иванов Иван Иванович (тут имя должно быть)</b></div>
                                    <a class="job-title resume-title">
                                        {{$response->getResume->job_title}}
                                    </a>
                                    <div class="city">{{$response->getResume->city->name}}</div>
                                    <div class="experience">
                                        Опыт: {{$response->getResume->experience_time}} года
                                    </div>
                                    @if(!empty($response->getResume->skills)) 
                                        <div class="skills">
                                            @foreach ($response->getResume->skills as $skill)
                                                <div class="skill__item">
                                                    {{$skill->name}}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="description">{{$response->getResume->description}}</div>
                                    <response-resume 
                                        response_id="{{$response->id}}"
                                        is_accept="{{$response->isAccept}}"
                                        is_checked="{{$response->isChecked}}">
                                    </response-resume>
                                </div>
                            @endforeach
                            @else
                            В данный момент откликов не поступало
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @include('templates.blocks.footer')
        <script src="/js/app.js"></script>
    </body>
</html>
