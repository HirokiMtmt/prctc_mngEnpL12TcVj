<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div id="app">
            <h1 class="text-3xl font-bold text-center mt-8">
                Welcome to Laravel with Vue.js and Tailwind CSS
            </h1>
        </div>
    </body>
</html>
