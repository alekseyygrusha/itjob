<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Личный кабинет</title>
        @include('templates.blocks.meta')
    </head>

    <body>
        @include('templates.blocks.header');
        <div class="container">
            <h2>Личный кабинет</h2>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="menu-block-buttons d-flex mb-4">
                <div class="button-item">
                    <a href="/cabinet/resume/" class="button-st -transparent">Опубликовать резюме</a>
                </div>

                <div class="button-item ml-2">
                    <a href="/cabinet/vacancy/" class="button-st -transparent">Опубликовать вакансию</a>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <h4>Список моих вакансий:</h4>
                    <div id="vacancy-container">
                        <div class="vacancies-container">
                            @foreach ($user_vacancies as $vacancy)
                                @include('templates.cabinet.vacancy_item', array('vacancy'=>$vacancy))
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <h4>Мои резюме</h4>
                    <div class="resume-wrap">
                        <div class="vacancies-container">
                            @if(!empty($user_resumes))
                                @foreach($user_resumes as $resume)
                                    <div class="vacancies-card">
                                        <div class="name"><b>Иванов Иван Иванович (имя добавить)</b></div>
                                        <a class="job-title resume-title">
                                            {{$resume->job_title}}
                                        </a>
                                        <div class="city">{{$resume->city->name}}</div>
                                        <div class="experience">Опыт: {{$resume->experience_time}} года</div>
                                        <div class="skills">
                                            @if(!empty($resume->skills))
                                                @foreach ($resume->skills as $skill)
                                                    <div class="skill__item">
                                                        {{$skill->name}}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="description">{{$resume->description}}</div>
                                        <div class="button-wrap">
                                            <a class="button-st -transparent -border-yellow" href='\cabinet\resume\{{$resume->id}}' data-value="{{$resume->id}}">
                                                Редактировать
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </body>
</html>


