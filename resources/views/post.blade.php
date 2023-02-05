<html>
    <head>
        <title>Разместить вакансию</title>
        @include('templates.blocks.meta')
    </head>
    <body>
        @include('templates.blocks.header')
        <div class="main-content" id="app">
            <div class="container">
                <div id="post-vacancy-form" class="post-vacancy-form">
                    
                    <post-vacancy cities='{{$cities->getContent()}}'></post-vacancy>
                </div>
                @include('templates.vacancies.post_form')
            </div>
        </div>
        @include('templates.blocks.footer')
        <script src="/js/app.js"></script>
    </body>
</html>   