@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="full-page-menu">
            <div class="row">
                <div class="col-6">
                    <a href="/cabinet/resume/" class="menu-item">
                        <img class="mb-2" src="/images/cv.png" alt="">
                        <div class="description">Опубликовать резюме</div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="/cabinet/vacancy/" class="menu-item -border-yellow">
                        <img src="/images/vacancy.png" alt="">
                        <div class="description">Опубликовать вакансию</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
