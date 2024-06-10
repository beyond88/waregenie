@extends("layouts.layout")
@section("title", "Media Details | Waregenie")
@section("content")
    <div class="container-scroller">

        @include("layouts.top-bar")

        <div class="container-fluid page-body-wrapper">

            @include("layouts.sidebar")

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Media Details </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('media')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Media Details</li>
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
                                        <h2>Media Details</h2>
                                        <img src="{{ asset('storage/media/' . basename($media->media_name))}}" alt="{{$media->media_name}}" />
                                        <table class="media-details-table">
                                            <tr>
                                                <td><strong>Name:</strong></td>
                                                <td>{{$media->media_name}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>File Type:</strong></td>
                                                <td>{{$media->media_name}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>File Size:</strong></td>
                                                <td>
                                                    <p>{{ $imageSize }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Upload Time:</strong></td>
                                                <td>{{$media->created_at->format('F j, Y, g:i a')}}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <a href="{{ route('download.media', ['filename' => $media->media_name]) }}">Download</a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td>

                                                    <form action="{{ url('media/delete/' . $media->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this media?');">
                                                        @csrf
                                                        <a href="{{url('media')}}">Back</a>&nbsp;
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm mt-2">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>

                                        </table>
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
