@extends('layouts.authlayout')

@section('content')   
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
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
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account</h1>
                        </div>
                        <form class="user" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ __('Name:') }}</label>
                                <input id="name" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" name="name" placeholder="Name" value="{{ old('name') }}" 
                                required autocomplete="name" autofocus>   

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email Address:') }}</label>
                                <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="email"  name="email"
                                    placeholder="Email Address" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="email">{{ __('Password:') }}</label>
                                    <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password"
                                        id="password" placeholder="Password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                <label for="email">{{ __('Repeat Password:') }}</label>
                                    <input type="password" class="form-control form-control-user" name="password_confirmation"
                                        id="password-confirm" placeholder="Repeat Password" required autocomplete="new-password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                    {{ __('Register') }}
                            </button>
                                
                        </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href={{route('login')}}>Already have an account? Login!</a>
                            </div>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 @endsection