<html>
<head>
    <title>Admin</title>
    @include('templates.blocks.meta')
</head>
<body>
    @include('templates.blocks.header');
    <div class="container">
        <div id="vacancy-container">
            @include('templates.admin.vacancies_list') 
        </div>
    </div>
    <script>
        $(document).ready(function() {
            //в отдельный JS файл вынести
            hideVacancy();
    
            function  hideVacancy() {
                $('.btn-hide').click(function(e){
                let element = $(this);
                let vacancy_id = e.target.dataset.value;
                e.preventDefault();
                
                $.ajax({
                    url: "{{ url('vacancy-hide') }}",
                    method: 'post',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "id": vacancy_id
                    },
                    success: function(result) {
                        $('#vacancy-container').html(result);
                        hideVacancy();
                    }
                });
                
                
            });
            }    
        });
    </script>
</body>