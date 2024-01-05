@extends('layouts.app')

@section('content')
    <div class="vacancy-card">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="info-box">
                        <div class="content">
                            <div class="content-item -title">Web-разработчик</div>
                            <div class="content-item -salary">от 70 000 до 120 000 ₽</div>
                            <div class="content-item -exp">Опыт работы: 3-6 лет</div>
                            <div class="content-item -company">Uber</div>
                            <div class="content-item -city">Санкт-Петербург</div>
                        </div>
                    </div>
                    <div class="main-description">
                        <div class="row">
                            <div class="col-4">
                                <div class="info-box description-block">
                                    <div class="block-heading">Технологии</div>
                                    <div class="skills-box">
                                        <div class="skills-box-item">Java</div>
                                        <div class="skills-box-item">MySQL</div>
                                        <div class="skills-box-item">PostgresSQL</div>
                                        <div class="skills-box-item">Базы данных</div>
                                        <div class="skills-box-item">Git</div>
                                        <div class="skills-box-item">Java Spring Framework</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="info-box description-block">
                                    <div class="block-heading">Описание вакансии</div>
                                    <div class="description">
                                        Наша компания ищет web-разработчика. Разработка сайтов по макетам. Опыт работы обязателен. Рассматриваем удаленных сотрудников.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 mt-4">
                    <div class="buttons-wrap">
                        <div class="button-st -transparent">Откликнуться</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
