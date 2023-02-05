
<div>
    <form class='form_block' action="{{route('vacancy-post')}}" method="post" id="post_vacancy">
        @csrf
        <!-- Equivalent to... -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" value="@if(!empty($vacancy)){{$vacancy->id}}@endif" name="vacancy_id">
        
        <input type="hidden">
        <div class="form_input">
            <h4>Название вакансии/должности:</h4> 
            <input type="text" value="@if(!empty($vacancy)){{$vacancy->job_title}}@endif" name="job_title">
        </div>
        <div>
            <select name="job_group" id="job_group">
                <option value="1" selected>Web</option>
                <option value="2">Design</option>
            </select>
        </div>
        
        <div class="form_input">
            <h4>Название компании:</h4> 
            <input type="text" value="@if(!empty($vacancy)){{$vacancy->company_name}}@endif" name="company_name">
        </div>
        
        <div class="form_input">
            <div class="row">
                <div class="col-6">
                    <h4>Город</h4> 
                </div>
                <div class="col-6">
                    <select name="city" id="city_select" style="width: 100%">
                        <option value="1" selected>Санкт-Петербург</option>
                        <option value="2" >Москва</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="form_input">
            <h4>Заработная плата:</h4> 
            <div class="row">
                <div class="col-6">
                    от
                    <input type='text' style="width: 100%" value="@if(!empty($vacancy)){{$vacancy->min_salary}}@endif" class="price" id="min_salary" onkeypress='validate(event)' name="min_salary">
                </div>
                <div class="col-6">
                    до
                    <input type='text' style="width: 100%" value="@if(!empty($vacancy)){{$vacancy->max_salary}}@endif" id="max_salary" onkeypress='validate(event)' name="max_salary">
                </div>
            </div>
        </div>
        @if(!empty($vacancy))
            <div class="form_input">
                <h4>Желаемые навыки</h4>    
                <div class="select_input">
                    <select name="skills[]"  id="skills_select" multiple>
                        @if(!empty($skills))
                            @foreach($skills as $skill)
                                <option value="{{$skill->id}}" 
                                    @if(!empty($vacancy->skills) && $vacancy->skills->contains('id', $skill->id))
                                        selected
                                    @endif
                                    >{{$skill->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>      
            </div>
        @endif
        <h4>Описание/Требования к сотруднику</h4> 
        <div class="form_input">
            <textarea name='description'>@if(!empty($vacancy)){{$vacancy->description}}@endif</textarea>
        </div>
        <button class="publucate-button button -green-color" action="confirm">Опубликовать</button>
        <div id="message"></div>
    </form>
</div>



