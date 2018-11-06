<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ trans('app.general.appName') }}</title>

        <link rel="stylesheet" href="{{ env('APP_URL') }}{{ mix('css/app.css') }}">

        <link rel="stylesheet" href="https://cdn.materialdesignicons.com/2.8.94/css/materialdesignicons.min.css">
        
        <script>
            window.App = {
                'lang': '{{ app()->getLocale() }}'
            };

            window.User = {
                'name': '{{ moodleauth()->user()->moodleuser->firstname }} {{ moodleauth()->user()->moodleuser->lastname }}',
                'id': '{{ moodleauth()->id() }}',
                'role': '{{ moodleauth()->user()->roles->first()->type }}'
            };

            var urlBase = '{{ env('APP_URL') }}';
        </script>
    </head>
    <body>
        <div id="app">
            @include('layouts.partials._nav')
        
            <div class="container">

                <section class="section">

                    @yield('content')

                </section>
                
            </div>

            <flash :flash="{{ json_encode(session('flash')) }}"></flash>
        </div>        

        @include('layouts.partials._trans')

        <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.js"></script> 

        <script src="{{ env('APP_URL') }}{{ mix('js/app.js') }}"></script>
    </body>
</html>
