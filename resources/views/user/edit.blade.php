@extends("layouts.layout")
@section("title", "Edit User | Waregenie")
@section("content")
    <div class="container-scroller">

        @include("layouts.top-bar")

        <div class="container-fluid page-body-wrapper">

            @include("layouts.sidebar")

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Edit User </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('user')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('user.update', $user->id) }}" class="forms-sample">
                                        @csrf  @method('PUT')

                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name" required class="form-control" placeholder="Name" value="{{ old('name', $user->name) }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Email</label>
                                            <input type="email" name="email" id="email" required class="form-control" placeholder="Email" value="{{ old('email', $user->email) }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Password</label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="{{ old('password', $user->password) }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Confirm Password</label>
                                            <input type="password" name="password" id="password_confirmation" class="form-control" placeholder="Password" value="{{ old('password', $user->password) }}">
                                        </div>

                                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                                        <button class="btn btn-light" onclick="window.location.href='/user'">Cancel</button>
                                    </form>

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
