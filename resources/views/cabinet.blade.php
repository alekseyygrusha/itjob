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