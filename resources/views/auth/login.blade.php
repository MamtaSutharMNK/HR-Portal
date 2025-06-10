@extends('layouts.authlayout')

@section('content')

<div class="container">
<!-- Outer Row -->
     <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <!-- Logo and images -->
                    <div class="row align-items-center">
                        <div class="col-lg-5 d-none d-lg-block bg-register-image">
                    <div></div>
                    <div class="mgalogo">
                        <img src="{{ asset('static\img\specialty-mga-uk.png')}}" alt="Specialty MGA UK Logo">
                    </div>
                    <div class="hrlogo">
                        <img src="{{ asset('static\img\human-resources.png')}}" alt="hr logo">
                    </div>
                </div>
                            <div class="col-lg d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">{{ __('Login') }} </h1>
                                    </div>
        <form  class='user' method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">{{ __('Email Address:') }}</label>
                <input id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email"
                placeholder="Email Address"  value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                @enderror    
            </div>
            <div class="form-group">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password:') }}</label>
                <input id="password" type="password" class="form-control form-control-user @error('email') is-invalid @enderror"
                    name="password" required autocomplete="current-password" placeholder="Password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox small">
                    <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary btn-user btn-block">{{ __('Login') }}</button>
            </div>
            
        </form>
        <hr>
        <div class="text-center">
            <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
        </div>
        <div class="text-center">
            <a class="small" href="{{ route('register') }}">Create an Account!</a>
        </div>
    </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

       
@endsection