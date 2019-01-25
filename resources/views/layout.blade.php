<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.header.meta')
    <title>ECRCHS Student Scores</title>

    <!-- Styles -->
    @include('partials.header.styles')

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- Sidebar -->
@include('partials.sidebar')

<!--Header-->
@include('partials.header.header')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('page-title')
                <small>@yield('page-description')</small>
            </h1>
            @include('partials.breadcrumbs')
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            @yield('content')
        </section>
    </div>

    @include('partials.footer.footer')
</div>

@include('partials.footer.scripts')
</body>
</html>
