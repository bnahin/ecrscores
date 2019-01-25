<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">NAVIGATION</li>
            <li class="treeview">
                <a href="#"><i class="fa fa-calendar"></i> <span>2016-2017</span>
                    <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                </a>
                <ul class="treeview-menu">
                    @for($i = 1; $i <= 5; $i++)
                        <li><a href="#">Course {{ $i }}</a></li>
                    @endfor
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-calendar"></i> <span>2017-2018</span>
                    <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                </a>
                <ul class="treeview-menu">
                    @for($i = 1; $i <= 5; $i++)
                        <li><a href="#">Course {{ $i }}</a></li>
                    @endfor
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-calendar"></i> <span>2018-2019</span>
                    <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                </a>
                <ul class="treeview-menu">
                    @for($i = 1; $i <= 5; $i++)
                        <li><a href="#">Course {{ $i }}</a></li>
                    @endfor
                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>