@extends('layouts.app')

@section('content')
    <div class="album py-5 bg-light">
        <div class="container">

            <div class="card text-center">
                <div class="card-header">
                    {{ $video->title }}
                </div>
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
                            Uploaded at: {{ $video->created_at }}
                        </div>
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-3">
                            {{  $video->views()->count() }} views
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card" style="width: 25rem;">
                    <div class="card-body">
                        <h5 class="card-title">Date info</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Uploaded at: {{ $video->created_at }}</li>
                        <li class="list-group-item">Optimization finished at:</li>
                        <li class="list-group-item"></li>
                    </ul>
                </div>
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Video details</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Duration: {{ $video->duration_string }}</li>
                        <li class="list-group-item">Original size: {{ $video->size }} MB</li>
                        <li class="list-group-item">Resolution: {{ $video->resolution_string }}</li>
                        <li class="list-group-item">@if ($video->job->is_finished) Optimized! @else Optimization in process {{ $video->job->progress_now }} @endif</li>
                        <li class="list-group-item">A second item</li>
                        <li class="list-group-item">A third item</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
@endsection
