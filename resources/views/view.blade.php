@extends('layouts.app')

@section('content')
    <div class="album py-5 bg-light">
        <div class="container">

            <div class="card text-center">
                <div class="card-body">
                    <p><video controls autoplay muted loop >
                            <source src="{{ asset('/storage/videos/'.$video->file) }}" type="video/mp4">
                            Your browser does not support HTML video.
                        </video>
                    </p>
                    <p class="float-end">
                        <a href="{{ url('/e/'.$video->tag)}}" class="btn btn-sm btn-outline-secondary" id="button" value="edit">Edit</a>
                        <button type="button" class="btn btn-sm btn-outline-danger" id="button" value="delete">Delete</button>
                    </p>
                </div>
                <div class="card-footer">
                    <p>

                    </p>
                    <div class="row">

                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            {{ $video->created_at }}
                        </div>
                        <div class="col-md-6">
                            {{ $video->title }}
                        </div>
                        <div class="col-md-3">
                            {{  $video->views()->count() }} views
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
