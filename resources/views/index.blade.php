<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <style>
            body {
                /*font-family: 'Nunito', sans-serif;*/
                font-family: cursive;
            }
        </style>
    </head>
    <body>
        <main id="app">
        </main>

        @vite('resources/js/app.js')
    </body>
</html>