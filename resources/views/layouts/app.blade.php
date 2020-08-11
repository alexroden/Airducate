<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('pageTitle', config('app.name'))</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/15181efa86.js" crossorigin="anonymous"></script>

    <script>
        window.grades = {!! json_encode($grades) !!};
        window.permissions = {!! json_encode($permissions) !!};
        window.token = '{{ $token }}';
        window.user_token= '{{ optional($auth)->token }}';
    </script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>

<section id="app" class="is-fullheight">
    @if($auth ?? null)
    <navbar :user="{{ $auth->toJson() }}"></navbar>
    @endif
    <alerts></alerts>
    <section class="container">
        <div class="columns is-multiline">
            @yield('content')
        </div>
    </section>
    <modal></modal>
</section>

</body>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

</html>
