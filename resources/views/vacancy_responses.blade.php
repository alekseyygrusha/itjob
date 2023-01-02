<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Отклики</title>
        @include('templates.blocks.meta')
    </head>
    <body>
        @include('templates.blocks.header');
        <div class="container">
            <h3>Отклики на вакансию {{$vacancy->job_title}}</h3>
            <p style="border-bottom: 1px solid #59b999">{{$vacancy->description}}</p>
            <div class="users-list">
                <div class="resume-wrap">
                    <div class="vacancies-container">
                        @if(!empty($vacancy_responses))
                            @foreach($vacancy_responses as $response)
                                <div class="vacancies-card">
                                    <div class="name"><b>Иванов Иван Иванович</b></div>
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
                                    <div class="button-wrap">
                                        <a class="button vacansy_response -green-color btn-success">
                                            Принять 
                                        </a>
                                        <a class="button btn-warning btn-hide" href='\cabinet\resume\{{$response->getResume->id}}' data-value="{{$response->getResume->id}}">
                                            Отклонить  
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
