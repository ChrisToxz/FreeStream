@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <livewire:upload-video />
    <div class="container">

            <livewire:show-videos/>

    </div>
    <script>
        function copy(text) {
            // TODO: proper copied feedback.
            navigator.clipboard.writeText(text);
            alert("Copied!");
        }
    </script>
@endsection
