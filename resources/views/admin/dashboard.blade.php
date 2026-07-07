
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- theme meta -->
    <meta name="theme-name" content="admin" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

{{--    Link Chart--}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.6.0/echarts.min.js"
            integrity="sha512-XSmbX3mhrD2ix5fXPTRQb2FwK22sRMVQTpBP2ac8hX7Dh/605hA2QDegVWiAvZPiXIxOV0CbkmUjGionDpbCmw=="
            crossorigin="anonymous" referrerpolicy="no-referrer">

    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

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
                    <input type="search" class="form-control" placeholder="Tìm kiếm Dashboard" aria-label="Search Dashboard">
                    <div class="drop-down animated flipInX d-md-none">
                        <form action="#">
                            <input type="text" class="form-control" placeholder="Tìm kiếm">
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
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="{{ asset('admin/images/user/1.png') }}" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href=""><i class="icon-user"></i>
                                                <span>
                                                    {{ Auth::user()->user_name }}
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="icon-envelope"></i>
                                                <span>{{ Auth::user()->email }}</span>
                                            </a>
                                        </li>
                                        <hr class="my-2">
                                        <li><a href="{{ route('admin.logoutAdmin')}}">
                                                <i class="icon-key"></i>
                                                <span>Đăng xuất</span>
                                            </a>
                                        </li>
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
                                            <a href="{{ route('admin.loginAdmin')}}"><i class="icon-lock"></i> <span>Đăng nhập</span></a>
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
                    <a href="{{route('admin.dashboard')}}" aria-expanded="false">
                        <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                    </a>

                </li>
                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-brands fa-slack"></i><span class="nav-text"> Quản lý sản phẩm</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin.products.index')}}"> Quản lý sản phẩm</a></li>
                        <li><a href="{{route('admin.products.create')}}">Thêm mới sản phẩm</a></li>
                    </ul>
                </li>

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-chart-simple"></i><span class="nav-text"> Quản lý danh mục</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin.categories.index')}} ">Danh sách danh mục</a></li>
                        <li><a href="{{route('admin.categories.create')}} ">Thêm mới danh mục</a></li>
                    </ul>
                </li>

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-cart-shopping"></i><span class="nav-text">Quản lý đơn hàng </span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin.orders.index')}}">Quản lý đơn hàng</a></li>

                    </ul>
                </li>
                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-gift"></i>
                        <span class="nav-text"> Quản lý mã giảm giá</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.promotions.index') }}">Danh sách mã  </a></li>
                        <li><a href="{{ route('admin.promotions.create') }}">Thêm mới mã giảm giá</a></li>
                    </ul>
                </li>
                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-people-group"></i><span class="nav-text"> Quản lý tài khoản</span>
                    </a>

                        <ul aria-expanded="false">
                            @can('user.view')
                            <li><a href="{{route('admin.users.index')}}">Danh sách tài khoản</a></li>
                            @endcan
                            @can('user.create')
                            <li><a href="{{route('admin.users.create')}}">Thêm mới tài khoàn</a></li>
                            @endcan
                        </ul>

                </li>

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-user-shield"></i>
                        <span class="nav-text">Quản lý vai trò - quyền</span>
                    </a>

                        <ul aria-expanded="false">
                            @can('role.view')
                            <li><a href="{{route('admin.roles.index')}}">Danh sách vai trò </a></li>
                            @endcan
                            @can('permission.view')
                            <li><a href="{{route('admin.permissions.index')}}">Danh sách quyền</a></li>
                                @endcan

                        </ul>

                </li>
                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-shirt"></i><span class="nav-text"> Quản lý thương hiệu</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.brands.index') }}">Danh sách thương hiệu</a></li>
                        <li><a href="{{ route('admin.brands.create') }}">Thêm mới thương hiệu</a></li>
                    </ul>
                </li>

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-palette"></i></i><span class="nav-text"> Quản lý màu</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.colors.index') }}">Danh sách màu</a></li>
                        <li><a href="{{ route('admin.colors.create') }}">Thêm mới màu</a></li>
                    </ul>
                </li>

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-brands fa-cotton-bureau"></i></i><span class="nav-text"> Quản lý chất liệu</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.materials.index') }}">Danh sách chất liệu </a></li>
                        <li><a href="{{ route('admin.materials.create') }}">Thêm mới chất liệu</a></li>
                    </ul>
                </li>

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-ruler"></i></i>
                       <span class="nav-text"> Quản lý size</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.sizes.index') }}">Danh sách size </a></li>
                        <li><a href="{{ route('admin.sizes.create') }}">Thêm mới size</a></li>
                    </ul>
                </li>

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-star"></i>
                        <span class="nav-text">Quản lý đánh giá</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.reviews.index') }}">Danh sách đánh giá</a></li>
                        <li><a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}">Chờ duyệt</a></li>
                    </ul>
                </li>

                <li class="mega-menu mega-menu-sm">
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-envelope"></i>
                        <span class="nav-text">Quản lý liên hệ</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.contacts.index') }}">Danh sách liên hệ</a></li>
                    </ul>
                </li>


                <li>
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa-solid fa-file-shield"></i></i><span class="nav-text">Cài đặt</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin.logoutAdmin')}}">Thông tin cá nhân</a></li>
                        <li><a href="{{route('admin.logoutAdmin')}}">Đăng xuất</a></li>
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
