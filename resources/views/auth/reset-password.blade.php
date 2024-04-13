@extends("layouts.layout")
@section("title", "Reset Password | WareGenie")
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
                            <h4>Confirm password</h4>
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form class="pt-3" method="POST" action="{{ route('password.store') }}">
                                @csrf

                                <div class="form-group">
                                    <input type="email" name="email" id="email" required class="form-control form-control-lg" placeholder="Email">
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" id="password" required maxlength="10" class="form-control form-control-lg" placeholder="Password">
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" required maxlength="10" class="form-control form-control-lg" placeholder="Confirm Password">
                                </div>

                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
