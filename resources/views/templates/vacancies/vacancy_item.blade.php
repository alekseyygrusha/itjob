
<div  class="vacancies-card vue-response-vacancy">
    <a href="/vacancy/{{$vacancy->id}}" class="job-title">
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
    <span class="experience">@if(!empty($vacancy->experience)) {{$vacancy->experience->text}}@endif</span>
    <div class="company">{{$vacancy->company_name}}</div>
    <div class="city">{{$vacancy->bindCity->name}}</div>
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
        @if(Auth::user())
            <response-vacancy
                resume_list="{{$resume_list->getContent()}}"
                id="{{$vacancy->id}}"
                responsed_id="@if(!empty($vacancy->vacancyResponses)){{$vacancy->vacancyResponses->resume_id}}@endif"
                >
            </response-vacancy>
        @endif

        {{-- <a class="btn btn-success -green-color" href='#'>Позвонить</a> --}}
    </div>
</div>
