<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    <div>


        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.movies.index') }}" class="text-blue-600 font-bold">
                    Admin Scherm
                </a>
            @endif
        @endauth
        @auth
            <a href="{{ route('profile.edit') }}">
                Naar Profiel
            </a>

        @else
            <div>
                <a href="{{ route('login') }}">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">
                        Registreren
                    </a>
                @endif
            </div>
        @endauth
    </div>
</body>

</html>