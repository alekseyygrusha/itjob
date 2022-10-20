<div class="vacancies-card">
    <a class="job-title">
        {{$vacancy->job_title}}
    </a>
    <div class="salary">от {{$vacancy->min_salary}} - до {{$vacancy->max_salary}} руб.</div>
    <div class="company">{{$vacancy->job_title}}</div>
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
        <button class="btn btn-warning btn-hide" data-value="{{$vacancy->id}}">
            @if(!$vacancy->is_hidden)
                    Скрыть
                @else
                    Показать
            @endif    
        </button>
        {{-- <a class="btn btn-danger" href='{{route('vacancy-block')}}'>Заблокировать</a> --}}
    </div>
</div>