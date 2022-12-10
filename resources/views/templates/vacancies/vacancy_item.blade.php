
<div class="vacancies-card vue-response-vacancy">
    <a class="job-title">
        {{$vacancy->job_title}}
    </a>
    <div class="salary">от {{$vacancy->min_salary}} - до {{$vacancy->max_salary}} руб.</div>
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
            {{-- <a class="btn  @if(!$vacancy->vacancyResponses) vacansy_response btn-success @else btn btn-secondary @endif -green-color" data-value="{{$vacancy->id}}">Откликнуться</a> --}}
            <response-vacancy resume_list="{{$resume_list->getContent()}}" id="{{$vacancy->id}}"></response-vacancy>
        @endif
        
        {{-- <a class="btn btn-success -green-color" href='#'>Позвонить</a> --}}
    </div>
</div>