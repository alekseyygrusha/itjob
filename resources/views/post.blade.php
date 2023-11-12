<html>
    <head>
        <title>Разместить вакансию</title>
        @include('templates.blocks.meta')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        @include('templates.blocks.header')
        <div class="main-content" id="app">
            <div class="container">
                <div id="post-vacancy-form" class="post-vacancy-form">
                    <post-vacancy groups={{$groups->getContent()}} experiences='{{$experiences->getContent()}}' skills='{{$skills->getContent()}}' vacancy='@if(!empty($vacancy)){{$vacancy}}@endif' cities='{{$cities->getContent()}}'></post-vacancy>
                </div>
                @include('templates.vacancies.post_form')
            </div>
        </div>
        @include('templates.blocks.footer')
        <script src="/js/app.js"></script>
    </body>
</html>   