@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="resume-wrap">
            <div class="vacancies-container responses-list">
                @foreach($vacancies_responses as $vacancy)
                    @include('templates.responses.vacancy_item', ['vacancy' => $vacancy]) 
                @endforeach
            </div>
        </div>
    </div>
@endsection