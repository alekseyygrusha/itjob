<div class="vacancies-card">
    <div class="satus-list mb-2">
        @if($vacancy->is_hidden)
            <div class="statis btn btn-warning">Скрыто администратором</div>
        @endif
    </div>

    <a class="job-title" href="/cabinet/vacancy/view/{{$vacancy->id}}">
        {{$vacancy->job_title}}
    </a>
    <div class="salary">
        @if(!empty($vacancy->min_salary) && $vacancy->min_salary !== 0 && !empty($vacancy->max_salary) && $vacancy->max_salary !== 0)
            от {{$vacancy->min_salary}} до {{$vacancy->max_salary}} ₽
        @elseif(!empty($vacancy->max_salary) && $vacancy->max_salary !== 0)
            до {{$vacancy->max_salary}} ₽
        @elseif(!empty($vacancy->min_salary) && $vacancy->min_salary !== 0)
            от {{$vacancy->min_salary}}
        @else
        @endif
    </div>
    <div class="company">{{$vacancy->company_name}}</div>
    <div class="city">{{$vacancy->city_name}}</div>
    <div class="description">{{$vacancy->description}}</div>
    <div class="skills">
        @if(!empty($vacancy->skills))
            @foreach ($vacancy->skills as $skill)
                <div class="skill__item">
                    {{$skill->name}}
                </div>
            @endforeach
        @endif
    </div>
    <div class="response-status-title">
        @if($vacancy->status->code === 'check')
            <span style="border-bottom: 3px solid #ffc107">На проверке</span>
        @endif
        @if($vacancy->status->code === 'published')
            <span style="border-bottom: 3px solid #59b999">Принято</span>
        @endif

        @if($vacancy->status->code === 'rejected')
            <span style="border-bottom: 3px solid red">Отклонено</span>
        @endif

            @if($vacancy->status->code === 'banned')
                <span style="border-bottom: 3px solid red">Заблокировано</span>
            @endif
    </div>
    <div class="button-wrap">
        <a href="/vacancy/response/{{$vacancy->id}}" class="button-st -transparent mr-2" data-value='{{$vacancy->id}}'>
            Отклики @if($vacancy->vacancyResponsesList)
            <span class="hint">{{$vacancy->vacancyResponsesList->count() < 99 ? $vacancy->vacancyResponsesList->count() :  '99+'}}</span>
            @endif
        </a>
        <a href="/cabinet/vacancy/view/{{$vacancy->id}}" class="button-st -transparent mr-2">Подробно</a>
        <a href="/vacancy/edit/{{$vacancy->id}}" class="button-st -border-yellow mr-2" data-value='{{$vacancy->id}}'>Редактировать</a>
    </div>
</div>
