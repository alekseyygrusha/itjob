<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ITjob</title>

    @include('templates.blocks.meta')
</head>
<body>
    @include('templates.blocks.header')
    <div class="main-content" id='app'>
        <main class="py-4">
            @section('content')@show
        </main>
    </div>
    @include('templates.blocks.footer')
    <script src="/js/app.js"></script>
</body>
</html>
