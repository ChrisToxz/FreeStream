@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="py-sm-0 text-center container">
        <div class="row">
            <div class="col-md-8 col-md-8 mx-auto">
                <p class="text-center">
                <div class="col-lg-12" >
                    <!-- File Input -->
                    <div class="row justify-content-center">
                        <input type="file" wire:model="video"  id="file" style="display: none;" x-ref="file" @change="file = $refs.file.files[0].name">
                        <button type="button" class="btn btn-outline-dark" onclick="document.getElementById('file').click();">Select video</button>
                    </div>
                </p>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p>Logged in!</p>
                </div>
            </div>
        </div>
    </div>
@endsection
