@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <livewire:upload-video />
    <div class="container">

            <livewire:show-videos/>

    </div>
@endsection
