@extends('shop.layout.master')
@section('title', 'My Account')

@section('content')
    <div class="container" style="margin-top: 200px">
        <div class="container" style="margin-bottom: 20px">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content text-center">
                        <h3>My Account</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom: 40px">
            <div class="col-sm-3">
                <div class="card" style="width: 16rem;">
                    <img id="previewImg" src="{{ $customer->img ? asset('storage/' . $customer->img) : 'default-image.png' }}" class="card-img-top" alt="Profile Image">
                </div>
            </div>
            <div class="col-sm-9">
                <form class="row g-3" method="POST" action="{{ route('profile.update', $customer->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <label for="inputName" class="form-label">User Name</label>
                        <input type="text" name="user_name" class="form-control" id="inputName" value="{{session('customer.user_name')}}">
                    </div>
                    <div class="col-md-6">
                        <label for="inputName" class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" id="inputName" value="{{session('customer.full_name')}}">
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" id="inputEmail" value="{{session('customer.email')}}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPhone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="inputPhone" placeholder="" value="{{session('customer.phone')}}">
                    </div>
                    <div class="col-md-12">
                        <label for="inputCity" class="form-label">Address Detail</label>
                        <input type="text" class="form-control" name="address" id="inputCity" value="{{session('customer.address')}}">
                    </div>
                    <div class="col-md-6">
                        <label for="inputImg" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" name="img" id="inputImg" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <div style="margin-left: 350px">
                        <button type="submit" name="submit" style="width: 200px;text-align: center;"
                                class="btn btn-danger">Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--    Hiển thị ảnh khi chọn ảnh để thay đổi--}}
    <script>
        function previewImage(event) {
            const input = event.target;
            const previewImg = document.getElementById('previewImg');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result; // Gán URL ảnh vào thẻ <img>
                }
                reader.readAsDataURL(input.files[0]); // Đọc file ảnh
            }
        }
    </script>

@endsection
