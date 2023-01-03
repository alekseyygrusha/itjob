<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Личный кабинет</title>
        @include('templates.blocks.meta')
    </head>
        
    <body>
        @include('templates.blocks.header');
        <div class="container">
            Личный кабинет
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
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
                                    <a class="btn btn-warning btn-hide" href='\cabinet\resume\{{$resume->id}}' data-value="{{$resume->id}}">
                                        Редактировать    
                                    </a>

                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <h4>Список моих вакансий:</h4>
            <div id="vacancy-container">
                <div class="vacancies-container">
                    @foreach ($user_vacancies as $vacancy)
                        @include('templates.cabinet.vacancy_item', array('vacancy'=>$vacancy))
                    @endforeach
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    $(document).ready(function() {
        //в отдельный JS файл вынести
        deleteVacancy();

        function deleteVacancy() {
            $('.delete_button').click(function(e){
                let vacancy_id = e.target.dataset.value;
                e.preventDefault();
                if (confirm('Удалить публикацию?')) {
                    $.ajax({
                        url: "{{ url('vacancy-delete') }}",
                        method: 'post',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "id": vacancy_id
                        },
                        success: function(result) {
                            $('#vacancy-container').html(result);
                            deleteVacancy();
                        }
                    });
                }
            });
        }    
    });
</script>