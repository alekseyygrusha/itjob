@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Добро пожаловать') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Вы вошли как ')  }} {{Auth::user()->name}}

                    
                </div>
                
            </div>
            <a href="/" class="mt-4 btn btn-success" style="color: white">На главную</a>
        </div>
    </div>
</div>
@endsection
