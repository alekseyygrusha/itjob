<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>ITjob</title>
        @include('templates.blocks.meta')
    </head>
    <body>
        @include('templates.blocks.header');
        <div class="container">
            <div class="main-content">
                <div class="row">
                    <div class="col-3">
                        <div class="options-bar">
                            {{-- <div class="vacancies-directions">
                                <div class="heading">
                                    Направления:
                                </div>
                                <div class="wrap">
                                    <div class="options-bar-item direction-item">GameDev</div>
                                    <div class="options-bar-item direction-item">System Administrators</div>
                                    <div class="options-bar-item direction-item">Managers</div>
                                    <div class="options-bar-item direction-item">Design</div>
                                    <div class="options-bar-item direction-item">Testing</div>
                                </div>
                            </div> --}}
            
                            <div class="city-directions">
                                <div class="heading">
                                    Города:
                                </div>
                                <div class="wrap">
                                    @if(!empty($city_list))
                                        @foreach($city_list as $city_item)
                                            <div class="options-bar-item" value="{{$city_item['id']}}">{{$city_item['name']}}</div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
            
                            <div class="city-directions">
                                <div class="heading">
                                    Зарплата:
                                </div>
                                <div class="wrap">
                                    <div class="options-bar-item">от 50 000 руб.</div>
                                    <div class="options-bar-item">от 85 000 руб.</div>
                                    <div class="options-bar-item">от 130 000 руб.</div>
                                    <div class="options-bar-item">от 180 000 руб.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="vacancies-container">
                            
                            @include('templates.vacancies.vacancies_list')
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                //в отдельный JS файл вынести
                responseVacancy();
        
                function responseVacancy() {
                    $('.vacansy_response').click(function(e) {
                        let vacancy_id = e.target.dataset.value;
                        e.preventDefault();
                    
                        $.ajax({
                        url: "{{ url('vacancy-response') }}",
                        method: 'post',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "id": vacancy_id
                        },
                        success: function(result) {
                            $('.vacancies-container').html(result);
                            responseVacancy();
                        }
                    });
                    
                });
                }    
            });

        </script>
    </body>
</html>
