@extends('layouts.authlayout')

@section('content')   

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-10">
                        <div class="text-center mt-5">
                            <a href="{{ route('index') }}" class="btn btn-secondary">Skip</a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>



@endsection