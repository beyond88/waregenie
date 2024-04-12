@extends("layouts.layout")
@section("title", "Register | Waregenie")
@section("content")

    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="../../images/logo.svg">
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign up to continue.</h6>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name" required class="form-control form-control-lg" id="name" placeholder="Full Name">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" required class="form-control form-control-lg" id="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" required maxlength="10" class="form-control form-control-lg" id="password" placeholder="Password">
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password_confirmation" required maxlength="10" class="form-control form-control-lg" id="confirmed" placeholder="Confirm Password">
                                </div>

                                <div class="mt-3">
                                    <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" style="background-color: #16afb2; border-color: #16afb2;" name="register" value="Sign Up">
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input"> Keep me signed in
                                        </label>
                                    </div>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Have an account? <a href="{{ route('login') }}" class="text-primary">Login</a>
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


