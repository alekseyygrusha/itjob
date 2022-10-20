<div class="vacancies-card">
    <div class="satus-list mb-2">
        @if($vacancy->is_hidden)
            <div class="statis btn btn-warning">Скрыто администратором</div>
        @endif
    </div>
    
    <a class="job-title">
        {{$vacancy->job_title}}
    </a>
    <div class="salary">от {{$vacancy->min_salary}} - до {{$vacancy->max_salary}} руб.</div>
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
    <div class="button-wrap">
        <a href="/vacancy/response/{{$vacancy->id}}" class="button edit_button -green-color" data-value='{{$vacancy->id}}'>Отклики</a>
        <a href="/vacancy/edit/{{$vacancy->id}}" class="button edit_button -green-color" data-value='{{$vacancy->id}}'>Редактировать</a>
        <a class="button delete_button -red-color" data-value='{{$vacancy->id}}'>Удалить</a>
    </div>
</div>