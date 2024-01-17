<html>
<head>
    <title>Admin</title>
    @include('templates.blocks.meta')
</head>
<body>
    @include('templates.blocks.header');
    <div class="container">

        <div class="row">
            <div class="col-8">
                <div id="vacancy-container">
                    @include('templates.admin.vacancies_list')
                </div>

            </div>
            <div class="col-4">
                <div class="admin-filter-panel d-flex flex-column col mb-4">
                    <div class="filter-item button-st -border-yellow mb-2">На рассмотрении</div>
                    <div class="filter-item button-st -transparent mb-2">Принятые</div>
                    <div class="filter-item button-st -border-yellow mb-2">Отклонённые</div>
                    <div class="filter-item button-st -red">Заблокированные</div>
                </div>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            //в отдельный JS файл вынести
            // TODO переделать на vue
            hideVacancy();

            function  hideVacancy() {
                $('.btn-ban').click(function(e){
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
