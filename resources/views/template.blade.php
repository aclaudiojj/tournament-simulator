<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{env('APP_NAME')}}</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            body {
                font-family: 'Lato', sans-serif;
            }

            header {
                background-color: #f7f7f7;
                border-bottom: 1px solid #d6d6d6;
                padding: 20px 0;
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <header>
            <div class="container">
                <h1>Tournament Simulator</h1>
            </div>
        </header>
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>