<div class="vacancies-card">
    <a class="job-title">
        {{$vacancy->getVacancy->job_title}}
    </a>
    <div class="salary">от {{$vacancy->getVacancy->min_salary}} - до {{$vacancy->getVacancy->max_salary}} руб.</div>
    <div class="company">{{$vacancy->getVacancy->company_name}}</div>
    <div class="city">{{$vacancy->getVacancy->city_name}}</div>
    <div class="description">{{$vacancy->getVacancy->description}}</div>
    <div class="skills">
        @if(!empty($vacancy->getVacancy->skills))
            @foreach ($vacancy->getVacancy->skills as $skill)
                <div class="skill__item">
                    {{$skill->name}}
                </div>
            @endforeach
        @endif
    </div>
    <div class="button-wrap">
        
    </div>
    <div class="response-status">
        <div class="status-color 
        @if($vacancy->isAccept && $vacancy->isChecked)
            -accept
        @elseif(!$vacancy->isAccept && $vacancy->isChecked)
            -declined
        @else
        @endif
        "></div>
    </div>
    <div class="response-status-title">
        
        @if($vacancy->userCancel)
            <span>Отменён</span>  
        @elseif($vacancy->isAccept && $vacancy->isChecked)
            <span style="color: #59b999">Принято</span>
        @elseif(!$vacancy->isAccept && $vacancy->isChecked)
            <span style="color: #fd3300">Отклонено</span>
        @else
            Ожидает ответа
        @endif
    </div>
    <div class="response-resume-title">Резюме: {{$vacancy->getResume->job_title}}</div>
</div>