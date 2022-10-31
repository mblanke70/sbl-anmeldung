<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

         <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel Livewire</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        @livewireStyles

        <link href="{{ asset('stepwizard.css') }}" rel="stylesheet">
    </head>
    <body>

        <div class="container">

            @if( empty($schueler) )

                <livewire:anmeldung /> 
            
            @else
            
                <h1 class="container pt-4">Bücher ausgeliehen</h1>

                <form action="/logout" method="POST" class="my-3">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>

                <form action="/reset" method="POST" class="my-3">
                    @csrf
                    <button type="submit" class="btn btn-warning">Buchwahlen löschen und Logout</button>
                </form>

            @endif
    
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        @livewireScripts
    </body>
</html>