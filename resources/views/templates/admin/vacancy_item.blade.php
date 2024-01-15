<div class="vacancies-card ">
    <a class="job-title">
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
