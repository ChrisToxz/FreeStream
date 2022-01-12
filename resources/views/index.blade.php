@extends('layouts.app')

@section('content')
    <section class="py-sm-0 text-center container">
        <div class="row py-lg-3">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">{{ config('app.name') }}</h1>
                <p class="lead text-muted">Simple, quick & opensource</p>
                <p class="text-center">

                @livewire('upload-video')

                </p>
            </div>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">
            <livewire:video />
    </div>
@endsection
