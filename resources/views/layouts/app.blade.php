<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ trans('app.general.appName') }}</title>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        
        <script>
            window.App = {
                'lang': '{{ app()->getLocale() }}'
            };

            window.User = {
                'name': '{{ moodleauth()->user()->moodleuser->firstname }} {{ moodleauth()->user()->moodleuser->lastname }}',
                'id': '{{ moodleauth()->id() }}',
                'role': '{{ moodleauth()->user()->roles->first()->type }}'
            };
        </script>
    </head>
    <body>

        @include('layouts.partials._lang-switcher')

        <div id="app">
            <div class="container">

                @yield('content')
                
            </div>

            <flash :flash="{{ json_encode(session('flash')) }}"></flash>
        </div>        

        @include('layouts.partials._trans')

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
