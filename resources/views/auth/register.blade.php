@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-sm-12 col-md-8 col-lg-5 my-5">
                <div class="d-flex justify-content-center mb-3">
                    <img src="{{ asset('logo.svg') }}">
                </div>

                <div class="card shadow-sm px-3">
                    <div class="card-body">
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
                        <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <!-- Name -->
                            <div class="mb-3">
                                <label for="username">
                                    Username
                                </label>
                                <input  class="form-control @error('username') is-invalid @enderror" id="username" type="text" name="username" value="{{ old('username') }}" required="required" autofocus="autofocus">
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email">
                                    Email
                                </label>
                                <input  class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required="required" autofocus="autofocus">
                            </div>
                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password">
                                    Confirm Password
                                </label>

                                <input  class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" required="required" autocomplete="new-password">
                            </div>
                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password-confirm">
                                    Password
                                </label>

                                <input  class="form-control @error('password_confirmication') is-invalid @enderror" id="password-confirm" type="password" name="password_confirmation" required="required" autocomplete="new-password">
                            </div>

                            <div class="mb-0">
                                <div class="d-flex justify-content-end align-items-baseline">
                                    @if (Route::has('login'))
                                        <a class="text-muted me-3 text-decoration-none" href="{{ route('login') }}">
                                            Already an account?
                                        </a>
                                    @endif
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


{{--                        <div class="row mb-3">--}}
{{--                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">--}}

{{--                                @error('password')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row mb-3">--}}
{{--                            <label for="" class="col-md-4 col-form-label text-md-end">{{ __('') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="password-confirm" type="password" class="form-control" name="" required autocomplete="new-password">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row mb-0">--}}
{{--                            <div class="col-md-6 offset-md-4">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    {{ __('Register') }}--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endsection--}}
