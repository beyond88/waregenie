@extends("layouts.layout")
@section("title", "Media New | Waregenie")
@section("content")
    <div class="container-scroller">

        @include("layouts.top-bar")

        <div class="container-fluid page-body-wrapper">

            @include("layouts.sidebar")

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Media New </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('media')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Media New</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
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

                                    <div class="media-upload-container">
                                        <h2>Media Upload</h2>

                                        <form method="post" action="{{ route('media.new') }}" class="upload-form" enctype="multipart/form-data">
                                            @csrf
                                            <label for="file">Choose File:</label>
                                            <input type="file" id="file" name="file" required />
                                            <button type="submit" name="upload" class="btn btn-success btn-fw">Upload</button>
                                        </form>

                                        <div class="preview" id="preview">
                                            <!-- Uploaded media will be displayed here -->
                                        </div>
                                    </div>
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
