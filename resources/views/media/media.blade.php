@extends("layouts.layout")
@section("title", "Media | Waregenie")
@section("content")
    <div class="container-scroller">

        @include("layouts.top-bar")

        <div class="container-fluid page-body-wrapper">

            @include("layouts.sidebar")

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Media Library </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('media')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Media Library</li>
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

                                    <div class="media-container">
                                        <div class="media-toolbar">
                                            <a href="{{ url('media/upload') }}" class="btn btn-success btn-fw">
                                                <i class="icon-plus"></i>
                                                Add New
                                            </a>
                                            <form class="form-inline float-right" action="{{ url('media') }}" method="GET">
                                                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search media..." value="{{ $search ?? '' }}">
                                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                                            </form>
                                        </div>

                                        <div class="media-list">
                                            @forelse ($media as $item)
                                            <div class="media-item">
                                                <a href="{{ url('media/' . $item->id) }}">
                                                    <img src="{{ asset('storage/media/' . basename($item->media_name))}}" alt="{{$item->media_name}}" />
                                                </a>
                                                <form action="{{ url('media/delete/' . $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this media?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm mt-2">Delete</button>
                                                </form>
                                            </div>
                                            @empty
                                                <p>Media not found!</p>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="media-pagination-container">
                                        {{ $media->links() }}
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
