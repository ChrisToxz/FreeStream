@extends('layouts.app')

@section('content')
    <div class="album py-5 bg-light">
        <div class="container">

            <div class="card text-center">
                <div class="card-body">
                    <video controls autoplay muted loop >
                        <source src="{{ asset('/storage/videos/'.$video->file) }}" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                    <p>

                        <form class="row" method="POST" action="{{ $video->tag ? url('e/'.$video->tag) : url('e') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text">Start</span>
                                <input type="text" class="form-control" name="start" placeholder="0">
                                <span class="input-group-text">End</span>
                                <input type="text" class="form-control" name="end" placeholder="0">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Edit</button>
                            </div>
                            </div>
                        </form>
                    </p>
                </div>
                <div class="card-footer">
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
