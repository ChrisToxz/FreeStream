@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-sm-12 col-md-8 col-lg-5 my-5">
                <div class="d-flex justify-content-center mb-3">
                    <img src="{{ asset('logo.svg') }}">
                </div>

                <div class="card shadow-lg px-3">
                    <div class="card-body">
                        <p class="text-body">This video is protected by a password.</p>
                        @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <div class="text-danger">{{ __('Whoops! Something went wrong.') }}</div>

                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('gate') }}">
                        @csrf
                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password">
                                    Password
                                </label>

                                <input  class="form-control" id="password" type="password" name="password" required="required" autocomplete="new-password">
                            </div>

                            <div class="mb-0">
                                <div class="d-flex justify-content-end align-items-baseline">

                                    <button type="submit" class="btn btn-dark">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
