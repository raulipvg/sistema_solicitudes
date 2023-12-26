@extends('layout.main')

@section('main-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <a href="{{ route('login.google') }}" class="btn btn-primary">Login con Google</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
