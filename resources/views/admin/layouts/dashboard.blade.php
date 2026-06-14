
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- theme meta -->
    <meta name="theme-name" content="admin" />

    <title>Admin</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href=" {{ asset('admin/images/favicon.png') }}">
    <!-- Pignose Calender -->
    <link href=" {{ asset('admin/plugins/pg-calendar/css/pignose.calendar.min.css') }} " rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href=" {{ asset('admin/plugins/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('admin/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}">
    <link href="{{ asset('admin/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link href="{{ asset('admin/css/style.css') }} " rel="stylesheet">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->

{{--    Link Chart--}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.6.0/echarts.min.js"
            integrity="sha512-XSmbX3mhrD2ix5fXPTRQb2FwK22sRMVQTpBP2ac8hX7Dh/605hA2QDegVWiAvZPiXIxOV0CbkmUjGionDpbCmw=="
            crossorigin="anonymous" referrerpolicy="no-referrer">

    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

{{--    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>--}}


    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

<div id="main-wrapper">

    <!--**********************************
        Nav header start
    ***********************************-->
    <div class="nav-header">
        <div class="brand-logo">
            <a href="">
                <b class="logo-abbr"><img src=" {{ asset('admin/images/logo.png') }}" alt=""> </b>
                <span class="logo-compact"><img src=" {{ asset('admin/images/logo-compact.png') }}" alt=""></span>
                <span class="brand-title">
                        <img src="{{ asset('admin/images/logo-text.png') }}" alt="">
                    </span>
            </a>
        </div>
    </div>
    <!--**********************************
        Nav header end
    ***********************************-->

    <!--**********************************
        Header start
    ***********************************-->
    <div class="header">
        <div class="header-content clearfix">

            <div class="nav-control">
                <div class="hamburger">
                    <span class="toggle-icon"><i class="icon-menu"></i></span>
                </div>
            </div>
            <div class="header-left">
                <div class="input-group icons">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                    </div>
                    <input type="search" class="form-control" placeholder="Search Dashboard" aria-label="Search Dashboard">
                    <div class="drop-down animated flipInX d-md-none">
                        <form action="#">
                            <input type="text" class="form-control" placeholder="Search">
                        </form>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <ul class="clearfix">
                    <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                            <i class="mdi mdi-email-outline"></i>
                            <span class="badge badge-pill gradient-1">3</span>
                        </a>
                        <div class="drop-down animated fadeIn dropdown-menu">
                            <div class="dropdown-content-heading d-flex justify-content-between">
                                <span class="">3 New Messages</span>
                                <a href="javascript:void()" class="d-inline-block">
                                    <span class="badge badge-pill gradient-1">3</span>
                                </a>
                            </div>
                            <div class="dropdown-content-body">
                                <ul>
                                    <li class="notification-unread">
                                        <a href="javascript:void()">
                                            <img class="float-left mr-3 avatar-img" src=" {{ asset('admin/images/avatar/1.jpg') }}" alt="">
                                            <div class="notification-content">
                                                <div class="notification-heading">Saiful Islam</div>
                                                <div class="notification-timestamp">08 Hours ago</div>
                                                <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-unread">
                                        <a href="javascript:void()">
                                            <img class="float-left mr-3 avatar-img" src=" {{ asset('admin/images/avatar/2.jpg') }}" alt="">
                                            <div class="notification-content">
                                                <div class="notification-heading">Adam Smith</div>
                                                <div class="notification-timestamp">08 Hours ago</div>
                                                <div class="notification-text">Can you do me a favour?</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void()">
                                            <img class="float-left mr-3 avatar-img" src=" {{ asset('admin/images/avatar/3.jpg') }}" alt="">
                                            <div class="notification-content">
                                                <div class="notification-heading">Barak Obama</div>
                                                <div class="notification-timestamp">08 Hours ago</div>
                                                <div class="notification-text">Hi Teddy, Just wanted to let you ...</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void()">
                                            <img class="float-left mr-3 avatar-img" src=" {{ asset('admin/images/avatar/4.jpg') }}" alt="">
                                            <div class="notification-content">
                                                <div class="notification-heading">Hilari Clinton</div>
                                                <div class="notification-timestamp">08 Hours ago</div>
                                                <div class="notification-text">Hello</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </li>
                    <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                            <i class="mdi mdi-bell-outline"></i>
                            <span class="badge badge-pill gradient-2">3</span>
                        </a>
                        <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
                            <div class="dropdown-content-heading d-flex justify-content-between">
                                <span class="">2 New Notifications</span>
                                <a href="javascript:void()" class="d-inline-block">
                                    <span class="badge badge-pill gradient-2">5</span>
                                </a>
                            </div>
                            <div class="dropdown-content-body">
                                <ul>
                                    <li>
                                        <a href="javascript:void()">
                                            <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                            <div class="notification-content">
                                                <h6 class="notification-heading">Events near you</h6>
                                                <span class="notification-text">Within next 5 days</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void()">
                                            <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                            <div class="notification-content">
                                                <h6 class="notification-heading">Event Started</h6>
                                                <span class="notification-text">One hour ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void()">
                                            <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                            <div class="notification-content">
                                                <h6 class="notification-heading">Event Ended Successfully</h6>
                                                <span class="notification-text">One hour ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void()">
                                            <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                            <div class="notification-content">
                                                <h6 class="notification-heading">Events to Join</h6>
                                                <span class="notification-text">After two days</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </li>

                    <li class="icons dropdown">
                        @if(session()->has('admin'))
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="{{ asset('admin/images/user/1.png') }}" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href=""><i class="icon-user"></i> <span>{{ session()->get('admin')->full_name }}</span></a>
                                        </li>
                                        <hr class="my-2">
                                        <li><a href="{{ route('logout')}}"><i class="icon-key"></i> <span>Log out</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="{{ asset('admin/images/user/1.png') }}" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href=""><i class="icon-lock"></i> <span>Login</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->

    <!--**********************************
        Sidebar start
    ***********************************-->
    <div class="nk-sidebar">
        <div class="nk-nav-scroll">
            <ul class="metismenu" id="menu">
                <li class="nav-label">Dashboard</li>
                <li>
                    <a href="{{route('dashboard')}}" aria-expanded="false">
                        <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                    </a>

                </li>
                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-brands fa-slack"></i><span class="nav-text">Product Management</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('products.index')}}">Product Management</a></li>
                        <li><a href="{{route('products.create')}}">Add new product</a></li>
                    </ul>
                </li>

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-chart-simple"></i><span class="nav-text">Category Management</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('categories.index')}} ">Category Management</a></li>
                        <li><a href="{{route('categories.create')}} ">Add new category</a></li>
                    </ul>
                </li>

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-cart-shopping"></i><span class="nav-text">Order Management </span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="">Order management</a></li>

                    </ul>
                </li>
                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-people-group"></i><span class="nav-text">Promotion Management</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('promotions.index') }}">Promotion List </a></li>
                        <li><a href="{{ route('promotions.create') }}">Add new vouncher</a></li>
                    </ul>
                </li>
                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-people-group"></i><span class="nav-text">Account Management</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('users.index')}}">Account List </a></li>
                        <li><a href="{{route('users.create')}}">Add new account</a></li>
                        <li><a href="{{route('roles.index')}}">Role - Permission Management</a></li>
                    </ul>
                </li>

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-shirt"></i><span class="nav-text">Brand Management</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('brands.index') }}">Brand List </a></li>
                        <li><a href="{{ route('brands.create') }}">Add new brand</a></li>
                    </ul>
                </li>

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-palette"></i></i><span class="nav-text">Color Management</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('colors.index') }}">Color List </a></li>
                        <li><a href="{{ route('colors.create') }}">Add new Color</a></li>
                    </ul>
                </li>

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-brands fa-cotton-bureau"></i></i><span class="nav-text">Material Management</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('materials.index') }}">Material List </a></li>
                        <li><a href="{{ route('materials.create') }}">Add new material</a></li>
                    </ul>
                </li>

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-hat-cowboy-side"></i><span class="nav-text">Size Management</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('sizes.index') }}">Size List </a></li>
                        <li><a href="{{ route('sizes.create') }}">Add new size</a></li>
                    </ul>
                </li>

                <li class="nav-label">ADDONS</li>
                <li>
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-file-circle-check"></i> <span class="nav-text">Report</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="">Inbox</a></li>
                        <li><a href="">Read</a></li>
                        <li><a href="">Compose</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-file-shield"></i></i><span class="nav-text">Settings</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="">Profile</a></li>
                        <li><a href="">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!--**********************************
        Sidebar end
    ***********************************-->

    <!--**********************************
        Content body start
    ***********************************-->

@yield('content')


<!-- /.End Page Content -->
    <!--**********************************
        Content body end
    ***********************************-->


    <!--**********************************
        Footer start
    ***********************************-->
{{--    <div class="footer">--}}
{{--        <div class="copyright">--}}
{{--            <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> 2018</p>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!--**********************************
        Footer end
    ***********************************-->
</div>


<!--**********************************
    Scripts
***********************************-->
<script src="{{ asset('admin/plugins/common/common.min.js') }}"></script>
<script src="{{ asset('admin/js/custom.min.js') }}"></script>
<script src="{{ asset('admin/js/settings.js') }}"></script>
<script src="{{ asset('admin/js/gleek.js') }}"></script>
<script src="{{ asset('admin/js/styleSwitcher.js') }}"></script>

<!-- Chartjs -->
<script src="{{ asset('admin/plugins/chart.js/Chart.bundle.min.js') }}"></script>
<!-- Circle progress -->
<script src="{{ asset('admin/plugins/circle-progress/circle-progress.min.js') }}"></script>
<!-- Datamap -->
<script src="{{ asset('admin/plugins/d3v3/index.js') }}"></script>
<script src="{{ asset('admin/plugins/topojson/topojson.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datamaps/datamaps.world.min.js') }}"></script>
<!-- Morrisjs -->
<script src="{{ asset('admin/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('admin/plugins/morris/morris.min.js') }}"></script>
<!-- Pignose Calender -->
<script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admin/plugins/pg-calendar/js/pignose.calendar.min.js') }}"></script>
<!-- ChartistJS -->
<script src="{{ asset('admin/plugins/chartist/js/chartist.min.js') }}"></script>
<script src="{{ asset('admin/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js') }}"></script>



<script src="{{ asset('admin/js/dashboard/dashboard-1.js') }}"></script>


<script src="{{ asset('admin/plugins/tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/tables/js/datatable-init/datatable-basic.min.js') }}"></script>

<script src="{{ asset('admin/plugins/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/plugins/validation/jquery.validate-init.js') }}"></script>


<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->

</body>

</html>
