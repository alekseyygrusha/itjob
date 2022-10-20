<div class="vacancies-container">
    @foreach ($user_vacancies as $vacancy)
        @include('templates.cabinet.vacancy_item', array('vacancy'=>$vacancy))
    @endforeach
</div>