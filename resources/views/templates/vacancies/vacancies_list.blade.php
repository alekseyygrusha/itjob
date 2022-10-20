@if(!empty($success))
    <div class="alert alert-success">
        {{ $success }}
    </div>
@endif
@foreach ($vacancies as $vacancy)
    @include('templates.vacancies.vacancy_item', array('vacancy'=>$vacancy))
@endforeach


