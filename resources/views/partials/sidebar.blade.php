<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('dist/img/ecr-logo.png') }} " class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ \Illuminate\Support\Facades\Auth::user()->full_name }}</p>
                <!-- Status -->
                @if(\App\Helpers\Helper::inSync())
                    <a href="#"><i class="fa fa-circle text-danger"></i> Sync In Progress</a>
                @else
                    <a href="#"><i class="fa fa-circle text-success"></i> Synchronized</a>
                @endif
            </div>
        </div>


        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">NAVIGATION</li>
            <li class="{{ (Route::currentRouteName() == "home") ? "active" : "" }}"><a href="/"><i
                        class="fa fa-home"></i>Home</a></li>
            @php $urlYear = $sidebarYear ?? null @endphp
            @foreach(Auth::user()->getYears() as $year)
                <li class="treeview {{ ($year === $urlYear) ? "menu-open" : "" }}">
                    <a href="#"><i class="fa fa-calendar"></i> <span>
                        {{ \App\Helpers\Helper::getFullYearString($year) }}</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu" @if($year === $urlYear) style="display: block;" @endif>
                        @foreach(Auth::user()->getCourses($year) as $course)
                            <li><a href="/view/{{ \App\Helpers\Helper::base64url_encode("$year.$course") }}"
                                   @if(Route::currentRouteName() == "view-course"
                                   && $courseSerialized == \App\Helpers\Helper::base64url_encode("$year.$course"))
                                   class="active" @endif>
                                    {{ $course }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>