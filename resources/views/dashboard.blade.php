@extends("layouts.layout")
@section("title", "Dashboard | Waregenie")
@section("content")
<div class="container-scroller">

    @include("layouts.top-bar")

    <div class="container-fluid page-body-wrapper">

        @include("layouts.sidebar")

        <div class="main-panel">
            <div class="content-wrapper">

            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
@endsection
