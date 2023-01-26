<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>
        <style>
            body {
                /*font-family: 'Nunito', sans-serif;*/
                font-family: cursive;
            }
        </style>
        <script>
            (function () {
                window.Laravel = {
                    csrf_token: '{{ csrf_token() }}' 
                }
            })();
        </script>
    </head>
    <body>
        {{Auth::user()}}
        <main id="app">
        </main>

        @vite('resources/js/app.js')
    </body>
</html>
