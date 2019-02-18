<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.header.meta')
    <title>ECRCHS Student Scores | Admin</title>

    <!-- Styles -->

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('/bower_components/Ionicons/css/ionicons.min.css') }}">

    <!--Select2-->
    <link href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet"/>

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/css/skins/skin-blue.min.css') }}">

    <!-- App Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="hold-transition login-page">
<!--Admin Select Content -->
<div class="login-box" id="admin-select">
    <div class="login-logo">
        <img src="{{ asset('dist/img/ecr-logo.png') }}" alt="ECRCHS" style="width:100px;">
        <br>
        <a href="#"><b>ECRCHS</b> Scores App</a>
    </div>
    <!-- /.login-logo -->
    <div class="box-header">
        <i class="fa fa-user"></i> {{ Session::get('admin-select') }}
        <p class="pull-right">
            <a href="{{ route('logout') }}" style="color:red"><i class="fa fa-sign-out"></i> Log Out</a>
        </p>
    </div>
    <div class="login-box-body">
        @if($errors->has('email'))
            <div class="alert alert-danger">
                @foreach ($errors->get('email') as $message)
                    <i class="fa fa-warning"></i> <strong>{{ $message }}</strong> <br>
                @endforeach
            </div>
        @endif
        <p class="login-box-msg">Select teacher to authenticate as</p>

        <form action="{{ route('admin-login') }}" method="post">
            @csrf
            <div class="form-group has-feedback">
                <select class="form-control" id="admin-select-email" name="email">
                    <option value="">-- Select One --</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher['email'] }}">
                            {{ $teacher['first_name'] }}, {{ $teacher['last_name'] }}
                            ({{ $teacher['email'] }})
                        </option>
                    @endforeach
                </select>
                <p class="help-block">You can only select from the {{ count($teachers) }} teachers that have logged in
                    after the last SBAC score
                    sync.</p>
            </div>
            <button type="submit" class="btn btn-success btn-block btn-flat"><i class="fa fa-sign-in"></i>
                Sign In
            </button>
        </form>
    </div>
    <!-- Quick Stats -->
    <div class="box-footer text-center">
        <h5>School Statistics</h5>
        <div class="row">
            <div class="col-md-6">
                <strong>SBAC ELA</strong>
                <br>
                <span class="sparklines-box"
                      values="{{ \App\Helpers\AdminChartsHelper::getSparkline("sbac","ela_scale") }}"></span>
                <br>
                <span class="sparklines-pie"
                      values="{{ \App\Helpers\AdminChartsHelper::getSparkline("sbac","ela_level") }}"></span>
            </div>
            <div class="col-md-6">
                <strong>SBAC Math</strong>
                <br>
                <span class="sparklines-box"
                      values="{{ \App\Helpers\AdminChartsHelper::getSparkline("sbac","math_scale") }}"></span>
                <br>
                <span class="sparklines-pie"
                      values="{{ \App\Helpers\AdminChartsHelper::getSparkline("sbac","math_level") }}"></span>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <strong>PSAT Reading</strong>
                <br>
                <span class="sparklines-box"
                      values="{{ \App\Helpers\AdminChartsHelper::getSparkline("psat","readwrite") }}"></span>
            </div>
            <div class="col-md-6">
                <strong>PSAT Math</strong>
                <br>
                <span class="sparklines-box"
                      values="{{ \App\Helpers\AdminChartsHelper::getSparkline("psat","math") }}"></span>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <div class="box-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Created by Blake Nahin (Class of 2019)
        </div>
        <!-- Default to the left -->
        <strong><i class="fa fa-lock"></i></strong>
    </div>
    <!-- /.login-box-body -->
</div>

<!-- Scripts -->

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- JS Cookie -->
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

<!-- Select2 -->
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }} "></script>

<!-- Sparkline Graphs -->
<script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>

<!-- App JS -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>