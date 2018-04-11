<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ trans('app.general.appName') }}</title>

        <link 
            rel="stylesheet" 
            href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        >

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        
        <script>
            window.App = {
                'lang': '{{ app()->getLocale() }}'
            };
        </script>
    </head>
    <body>

        @include('layouts.partials._lang-switcher')

        <div id="app">
            <example-component></example-component>
        </div>

        <form action="/test" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            
            <div class="field">
                <div class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="myfile">

                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fa fa-upload"></i>
                            </span>

                            <span class="file-label">
                                Choose a file…
                            </span>
                        </span>

                        <span class="file-name">
                            
                        </span>
                    </label>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-info" type="submit">Submit</button>
                </div>
            </div>
        </form>


        @if (session()->has('error'))

            <table class="table">
                <thead>
                    <tr>

                        @foreach (session()->get('headers') as $header)
                            
                            <th>

                                {{ $header }}

                            </th>

                        @endforeach

                    </tr>
                </thead>

                <tbody>
                    
                    @foreach (session()->get('error') as $row)

                        <tr>

                            @foreach($row["data"] as $data)

                                <td>{{ $data }}</td>
                                

                            @endforeach


                            
                        </tr>
                        <tr>
                            <td colspan="{{ count($row['data']) }}">
                                <article class="message is-danger">
                                    <div class="message-body">
                                        <ul>
                                            @foreach($row["errors"] as $error)
                                                <li>&bull; {{ $error[0] }}</li>
                                            @endforeach
                                        </ul>
                                    </div
                                </article>
                            </td>
                        </tr>
                        

                    @endforeach

                </tbody>
            </table>

        @endif

        @include('layouts.partials._trans')

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
