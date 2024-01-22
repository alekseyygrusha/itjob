@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if($status === 'check')
                    Вакансия ещё не прошла модерацию
                @endif
                @if($status === 'rejected')
                    Вакансия отклонена
                @endif

                @if($status === 'banned')
                    Вакансия заблокирована администрацией
                @endif
            </div>
        </div>
    </div>
@endsection

