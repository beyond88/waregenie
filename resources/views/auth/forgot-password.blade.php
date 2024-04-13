@extends("layouts.layout")
@section("title", "Forgot Password | WareGenie")
@section("content")

    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="{{ asset('images/waregenie-logo.png') }}">
                            </div>
                            <h4>Lost password</h4>
                            <h6 class="font-weight-light">Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.</h6>

                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form class="pt-3" method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" required class="form-control form-control-lg" id="email" placeholder="Email">
                                </div>

                                <div class="mt-3">
                                    <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" style="background-color: #16afb2; border-color: #16afb2;" name="submit" value="Reset Password">
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Don't have an account? <a href="{{ route('register') }}" class="text-primary">Create</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
@endsection


