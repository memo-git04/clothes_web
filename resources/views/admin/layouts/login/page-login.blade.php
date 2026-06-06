
<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>AdminLogin</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/images/favicon.png') }}">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">

</head>

<body class="h-100">
<div class="login-form-bg h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-xl-6">
                <div class="form-input-content">
                    <div class="card login-form mb-0">
                        <div class="card-body pt-5">
                            <a class="text-center" href="">
                                <h4>Admin Login</h4>
                            </a>
                        </div>  
                    <form class="mt-5 mb-5 login-input" action="{{route('admin.loginProcess')}}" method="post" style="padding: 30px">
                        @csrf
                        @if ($errors->has('adminError'))
                            <div class="alert alert-danger alert-dismissible fade show font-sans" style="padding: 10px 15px; font-size: 13px; border-radius: 4px; margin-bottom: 20px;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="padding: 6px 12px;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Lỗi!</strong> {{ $errors->first('adminError') }}
                            </div>
                        @endif

                        <div class="form-group">
                        {{-- <label>Email</label> --}}
                            <input type="email" value="" name="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                         {{-- <label>Email</label> --}}
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <button class="btn login-form__btn submit w-100" name="login" value="login" type="submit">Log In</button>
                        
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!--**********************************
    Scripts
***********************************-->
<script src="{{ asset('admin/plugins/common/common.min.js') }}"></script>
<script src="{{ asset('admin/js/custom.min.js') }}"></script>
<script src="{{ asset('admin/js/settings.js')}}"></script>
<script src="{{ asset('admin/js/gleek.js')}}"></script>
<script src="{{ asset('admin/js/styleSwitcher.js')}}"></script>

</body>
</html>
