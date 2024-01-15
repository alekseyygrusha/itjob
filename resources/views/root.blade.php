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
                            <div class="vue-vacancy-filter">
                                <vacancy-filter experiences='{{$experiences->getContent()}}' cities='{{$cities->getContent()}}' skills='{{$skills->getContent()}}'></vacancy-filter>
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
        @include('templates.blocks.footer')
        <script src="/js/app.js"></script>
    </body>
</html>
