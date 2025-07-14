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
                        <img src="{{ asset('static\img\MNK group Logo.svg')}}" alt="Specialty MGA UK Logo">
                    </div>
                    <div class="hrlogo">
                        <img src="{{ asset('static\img\human-resources.png')}}" alt="hr logo">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4" style="font-family: 'Gotham', sans-serif;">Create an Account</h1>
                        </div>
                        <form class="user" method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
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
                                <label for="email">{{ __('Employee ID:') }}</label>
                                <input id="emp_id" type="text" class="form-control form-control-user @error('emp_id') is-invalid @enderror" name="emp_id" placeholder="Employee ID" value="{{ old('emp_id') }}" 
                                required autocomplete="emp_id"  pattern="^mnkgcs\d+$" title="Employee ID must start with 'mnkgcs' followed by numbers only">   
                                <div id="errorFeedBack" style='color:#E74A4C;  font-weight:bold; font-size:small; font-family: "Gotham", sans-serif;'></div>
                                
                                @error('emp_id')
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
                                <a class="small" href="{{route('login')}}">Already have an account? Login!</a>
                            </div>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 @endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const empInput = document.getElementById("emp_id");

    empInput.onchange = function () {
        const pattern = /^mnkgcs\d+$/i;
        const value = empInput.value;
        const errorFeedback = empInput.nextElementSibling;

        if (!pattern.test(value)) {
            empInput.classList.add("is-invalid");
            errorFeedback.innerHTML ="Enter correct employee Id";
        } else {
            empInput.classList.remove("is-invalid");
            errorFeedback.innerHTML = "";
        }
    };
});
</script>
@endpush
