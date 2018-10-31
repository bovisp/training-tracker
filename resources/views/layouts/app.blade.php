<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ trans('app.general.appName') }}</title>

        <link rel="stylesheet" href="css/app.css">
        
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
        @include('layouts.partials._notifications')

        <div id="app">
            <div class="container">

                @yield('content')
                
            </div>

            <flash :flash="{{ json_encode(session('flash')) }}"></flash>
        </div>        

        @include('layouts.partials._trans')

        <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.js"></script> 

        <script src="js/app.js"></script>
    </body>
</html>
