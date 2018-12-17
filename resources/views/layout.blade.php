<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.header.meta')
    <title>ECRCHS Student Scores</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    @include('partials.header.styles')

</head>
<body>
<div id="app">
    <main class="py-4 container">
        @yield('content')
    </main>
</div>

@include('partials.footer.footer')
@include('partials.footer.scripts')
</body>
</html>
