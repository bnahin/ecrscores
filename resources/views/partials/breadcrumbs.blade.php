<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    @hasSection('year')
        @yield('year')
    @endif
    @hasSection('course')
        @yield('course')
    @endif
</ol>