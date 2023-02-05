<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>ITjob</title>
        @include('templates.blocks.meta')
    </head>
    <body>
        @include('templates.blocks.header')
        
        <div class="main-content" id='app'>
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <div class="options-bar">
                            <div class="groups">
                                <div class="heading">
                                    Направления:
                                </div>
                                <div class="wrap">
                                    @if(!empty($groups_list))
                                        @foreach($groups_list as $group_item)
                                            <div class="options-bar-item" data-value="{{$group_item['id']}}">{{$group_item['group_name']}}</div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="city-directions">
                                <div class="heading">
                                    Города:
                                </div>
                                <div class="wrap">
                                    @if(!empty($city_list))
                                        @foreach($city_list as $city_item)
                                            <div class="options-bar-item" data-value="{{$city_item['id']}}">{{$city_item['name']}}</div>
                                        @endforeach
                                    @endif
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

                $('.city-directions .options-bar-item').click(function(e) {
                    getVacanciesByCities(e);
                });

                $('.groups .options-bar-item').click(function(e) {
                    getVacanciesByGroup(e);
                });
                
                function getVacanciesByGroup (e) {
                    let group_id = e.target.dataset.value;
                    console.log(group_id);
                    e.preventDefault();
                    $.ajax({
                        url: `{{ url('filter/group/${group_id}') }}`,
                        method: 'GET',
                        success: function(result) {
                            $('.vacancies-container').html(result);
                        }
                    });
                }

                function getVacanciesByCities(e) {
                    let city_id = e.target.dataset.value;
                    console.log(city_id);
                    e.preventDefault();
                    $.ajax({
                        url: `{{ url('filter/city/${city_id}') }}`,
                        method: 'GET',
                        success: function(result) {
                            $('.vacancies-container').html(result);
                        }
                    });
                }
            });
        </script>
        @include('templates.blocks.footer')
        <script src="/js/app.js"></script>
    </body>
</html>
