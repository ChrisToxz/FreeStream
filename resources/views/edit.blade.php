@extends('layouts.app')

@section('content')
    <div class="album py-5 bg-light">
        <div class="container">

            <div class="card text-center">
                <div class="card-body">
                    <form method="POST" action="{{ $video->tag ? url('e/'.$video->tag) : url('e') }}">
                        @csrf

                        <div class="row mb-3">
                            <input id="start" type="text" name="start" value="0" required>
                            <input id="end" type="text" name="end" value="0" required>
                        </div>
                        <button class="btn-primary" type="submit">Edit</button>
                    </form>
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
