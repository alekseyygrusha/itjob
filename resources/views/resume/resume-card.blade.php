@extends('layouts.app')

@section('content')
    <div class="post-resume-form">
        <post-resume :resume="{{$resume}}" :cities="{{$cities}}" :groups="{{$groups}}" :skills="{{$skills}}"  :experiences="{{$experiences}}"></post-resume>
    </div>
@endsection

