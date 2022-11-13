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
                    <div class="vacancies-card">
                        <div class="name"><b>Иванов Иван Иванович</b></div>
                        <a class="job-title resume-title">
                            Web-разработчик
                        </a>
                        <div class="city">Санкт-Петербург</div>
                        <div class="experience">Опыт: 3 года</div>
                        <div class="description">Ищу работу в хорошей компании</div>
                        <div class="button-wrap">
                            <a class="btn btn-warning btn-hide" href='\cabinet\resume\1' data-value="1">
                                Редактировать    
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <h4>Список моих вакансий:</h4>
            <div id="vacancy-container">
                @include('templates.cabinet.vacancies_list')
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