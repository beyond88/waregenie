@extends("layouts.layout")
@section("title", "Create User | Waregenie")
@section("content")
    <div class="container-scroller">

        @include("layouts.top-bar")

        <div class="container-fluid page-body-wrapper">

            @include("layouts.sidebar")

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Create User </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('user')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create User</li>
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

                                    <form method="POST" action="{{ route('user.create') }}" class="forms-sample">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name" required class="form-control" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Email</label>
                                            <input type="email" name="email" id="email" required class="form-control" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Password</label>
                                            <input type="password" name="password" id="password" required class="form-control" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Confirm Password</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Confirm Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select name="role_id" id="role_id" class="form-control">
                                                <option value="">Select Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary mr-2">Create</button>
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
