<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="/" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>ECR</b>Scores</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>ECR</b>Scores</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="">
                    <a href="#" style="cursor:default;">
                        <span><i class="fa fa-user"></i> {{ Auth::user()->full_name }}</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('logout') }}" style="color:red">
                        <i class="fa fa-sign-out"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>