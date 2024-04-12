@extends("layouts.layout")
@section("title", "Profile | Waregenie")
@section("content")
    <div class="container-scroller">

        @include("layouts.top-bar")

        <div class="container-fluid page-body-wrapper">

            @include("layouts.sidebar")

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Edit Profile </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('user')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @if (session()->has('message') && session()->get('type') === 'success')
                                        <div class="alert alert-success">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif

                                    @if (session('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('user.profile') }}" class="forms-sample" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type='file' name="file" id="file" class="form-control"/>
                                        </div>
                                        <div class="form-group profile-avatar-area">
                                            <img id="profile-avatar" src="{{ asset('images/avatar.png') }}" style="width: 100%;">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name" required class="form-control" placeholder="Name" value="{{Auth::user()->name}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Email</label>
                                            <input type="email" name="email" id="email" required class="form-control" placeholder="Email" value="{{Auth::user()->email}}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Password</label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Confirm Password</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">
                                        </div>
                                        <button type="submit" class="btn btn-primary mr-2">Save Changes</button>
                                    </form>

                                    <script>
                                        window.addEventListener('load', function () {
                                            let fileInput = document.querySelector('input[type="file"]');
                                            let imgPreview = document.getElementById('profile-avatar');

                                            fileInput.addEventListener('change', function () {
                                                if (this.files && this.files[0]) {
                                                    let file = this.files[0];

                                                    if (file.size > 2048 * 1024) {
                                                        alert('Image size cannot exceed 2 MB. Please select a smaller image.');
                                                        return;
                                                    }

                                                    if (!['image/jpg', 'image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
                                                        alert('Invalid image format. Please select a JPEG, PNG, or GIF image.');
                                                        return;
                                                    }

                                                    let imgURL = URL.createObjectURL(file);
                                                    imgPreview.src = imgURL;

                                                    imgPreview.onload = function () {
                                                        URL.revokeObjectURL(imgURL);
                                                    };
                                                }
                                            });
                                        });
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
@endsection
