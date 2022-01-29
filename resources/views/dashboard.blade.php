@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <livewire:upload-video />
    <div class="container">

            <livewire:show-videos/>

    </div>
    <footer class="text-muted py-5">
        <div class="container">
            <p class="float-end mb-1">
                <a href="#">Back to top</a>
            </p>
            <p class="mb-1">Powered by <a href="">Slipstream</a> @version</p>
            <p class="mb-0"></p>
        </div>
    </footer>
    <script>
        function copy(text) {
            // TODO: proper copied feedback.
            navigator.clipboard.writeText(text);
            alert("Copied!");
        }
    </script>
@endsection
