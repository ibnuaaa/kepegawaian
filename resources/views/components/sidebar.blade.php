<!-- BEGIN SIDEBPANEL-->
<nav class="page-sidebar" data-pages="sidebar">
    <!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
    <div class="sidebar-overlay-slide from-top" id="appMenu">
        <div class="row">
            <div class="col-xs-6 no-padding">
                <a href="#" class="p-l-40"><img src="/assets/img/demo/social_app.svg" alt="socail"></a>
            </div>
            <div class="col-xs-6 no-padding">
                <a href="#" class="p-l-10"><img src="/assets/img/demo/email_app.svg" alt="socail"></a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 m-t-20 no-padding">
                <a href="#" class="p-l-40"><img src="/assets/img/demo/calendar_app.svg" alt="socail"></a>
            </div>
            <div class="col-xs-6 m-t-20 no-padding">
                <a href="#" class="p-l-10"><img src="/assets/img/demo/add_more.svg" alt="socail"></a>
            </div>
        </div>
    </div>
    <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
    <!-- BEGIN SIDEBAR MENU HEADER-->
    <div class="sidebar-header">
        <img src="/assets/img/logo_white.png" alt="logo" class="brand" data-src="/assets/img/logo_white.png" data-src-retina="/assets/img/logo_white_2x.png" width="78" height="22">
        <div class="sidebar-header-controls">
            <button type="button" class="btn btn-xs sidebar-slide-toggle btn-link m-l-20" data-pages-toggle="#appMenu"><i class="fa fa-angle-down fs-16"></i>
            </button>
            <button type="button" class="btn btn-link d-lg-inline-block d-xlg-inline-block d-md-inline-block d-sm-none d-none" data-toggle-pin="sidebar"><i class="fa fs-12"></i>
            </button>
        </div>
    </div>
    <!-- END SIDEBAR MENU HEADER-->
    <!-- START SIDEBAR MENU -->
    <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">

            <li class="m-t-30 ">
                <a href="{!! url('/'); !!}" class="detailed">
                    <span class="title">Dashboard</span>
                </a>
                <span class="icon-thumbnail"><i class="far fa-file"></i></span>
            </li>

            @if (getPermissions('user')['checked'])
            <li class="">
                <a href="javascript:;">
                    <span class="title">User</span>
                </a>
                <span class="icon-thumbnail"><i class="fas fa-chevron-right"></i></span>
                <ul class="sub-menu">
                    @if (getPermissions('profile')['checked'])
                    <li>
                        <a href="{!! url('/profile'); !!}">Profil User</a>
                        <span class="icon-thumbnail"><i class="fas fa-users"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('position')['checked'])
                    <li>
                        <a href="{!! url('/position'); !!}">Jabatan</a>
                        <span class="icon-thumbnail"><i class="fas fa-tag"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('change_password')['checked'])
                    <li>
                        <a href="{!! url('/change_password'); !!}">Ganti Password</a>
                        <span class="icon-thumbnail"><i class="fas fa-lock"></i></span>
                    </li>
                    @endif
                    @if (getPermissions('user')['checked'])
                    <li>
                        <a href="{!! url('/user'); !!}">Semua Admin</a>
                        <span class="icon-thumbnail"><i class="fas fa-user-friends"></i></span>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            <li class="">
                <a href="{!! url('/logout'); !!}" class="detailed">
                    <span class="title">Logout</span>
                    <span class="details">Exit from the app</span>
                </a>
                <span class="icon-thumbnail"><i class="fas fa-sign-out-alt"></i></span>
            </li>



        </ul>
        <div class="clearfix"></div>
    </div>
    <!-- END SIDEBAR MENU -->


</nav>
<!-- END SIDEBAR -->
