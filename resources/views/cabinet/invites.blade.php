@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="user-vacancy-invites">
                    @if(!empty($vacancies_invites))
                        @foreach($vacancies_invites as $invite)
                            <div class="invite-item">
                                Обратите внимание на вакансию <a href="/vacancy/{{$invite->vacancy->id}}">{{$invite->vacancy->job_title}}</a> компании <b>{{$invite->vacancy->company_name}}</b>. Город <b>{{$invite->vacancy->bindCity->name}}</b>. Потенциальный работодатель заинтересовался вашим резюме <a href="/cabinet/resume/{{$invite->resume->id}}">{{$invite->resume->job_title}}</a>!
                            </div>
                        @endforeach
                    @else
                        <p>Тут будут уведомления о приглашениях на отклик к вакансии</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
