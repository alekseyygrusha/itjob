<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Отклики</title>
        @include('templates.blocks.meta')
    </head>
    <body>
        @include('templates.blocks.header');
        <div class="container">
            <div class="users-list">
                @if(!empty($vacancy_responses))
                    <h3>Отклики на вакансию {{$vacancy->job_title}}</h3>
                    <p>{{$vacancy->description}}</p>
                    <div class="row">
                        @if($vacancy_responses->count() >= 1)
                            @foreach($vacancy_responses as $response_user)
                                <div class="col-7">
                                    <div class="users-list__item">
                                        <div class="wrap">
                                            <div class="name">{{$response_user->user->name}}</div>
                                            <div class="mail">{{$response_user->user->email}}</div>
                                            <div class="time">Отклик получен: {{$response_user->created_at}}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @else
                            <div class="col-12">
                                <h3>Откриков не поступало</h3>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        
    </body>
</html>
