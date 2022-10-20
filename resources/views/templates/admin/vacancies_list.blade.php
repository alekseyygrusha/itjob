<div class="vacancies-container">
    @if(!empty($vacancies))
        @foreach ($vacancies as $vacancy)
            @include('templates.admin.vacancy_item', array('vacancy'=>$vacancy)) 
        @endforeach
    @endif
</div>