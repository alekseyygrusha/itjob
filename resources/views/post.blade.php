<html>
    <head>
        <title>Разместить вакансию</title>
        @include('templates.blocks.meta')
    </head>
    <body>
        @include('templates.blocks.header')
        <div class="main-content">
            <div class="container">
                @include('templates.vacancies.post_form')
            </div>
        </div>
        @include('templates.blocks.footer')
    </body>
</html>   