@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- {{route('resume-post')}} --}}
        <form class='form_block' action="{{route('resume-post')}}" method="post" id="post_resume">
            @csrf
            <!-- Equivalent to... -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" value="@if(!empty($resume)){{$resume->id}}@endif" name="resume_id">
            
            <input type="hidden">
            <div class="form_input">
                <h4>Название вакансии/должности:</h4> 
                <input type="text" value="@if(!empty($resume)){{$resume->job_title}}@endif" name="job_title">
            </div>
            <div class="form_input">
                
                <select name="job_group" id="job_group">
                    <option value="" default>Выберите группу</option>
                    @foreach($groups_list as $group)
                        <option value="{{$group->id}}" @if(!empty($resume->group) && $resume->group->id === $group->id) selected @endif>{{$group->group_name}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form_input">
                <div class="row">
                    <div class="col-6">
                        <h4>Город</h4> 
                    </div>
                    <div class="col-6">
                        <select name="city_id" id="city_select" style="width: 100%">
                            @foreach($city_list as $city)
                                <option value="{{$city->id}}" @if(!empty($resume->city) && $resume->city->id == $city->id) selected @endif>{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form_input">
                <h4>Желаемая заработная плата:</h4> 
                <div class="row">
                    <div class="col-6">
                        от
                        <input type='text' style="width: 100%" value="@if(!empty($resume)){{$resume->min_salary}}@endif" class="price" id="min_salary" onkeypress='validate(event)' name="min_salary">
                    </div>
                    <div class="col-6">
                        до
                        <input type='text' style="width: 100%" value="@if(!empty($resume)){{$resume->max_salary}}@endif" id="max_salary" onkeypress='validate(event)' name="max_salary">
                    </div>
                </div>
            </div>
            <div class="form_input">
                <h4>Мои навыки навыки</h4>
                <div class="select_input">
                    <select name="skills[]"  id="skills_select" multiple>
                        @if(!empty($skills))
                            @foreach($skills as $skill)
                                <option value="{{$skill->id}}" 
                                    @if(!empty($resume->skills) && $resume->skills->contains('id', $skill->id))
                                        selected
                                    @endif
                                    >{{$skill->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>      
            </div>
            
            <h4>Описание</h4> 
            <div class="form_input">
                <textarea name='description'>@if(!empty($resume)){{$resume->description}}@endif</textarea>
            </div>
            <div class="d-flex">
                <button class="publucate-button button -green-color" action="confirm">Опубликовать</button>
                <div class="publucate-button delete_button button -red-color ml-4" data-value="{{$resume->id}}">Удалить</div>
            </div>
            
            <div id="message"></div>
        </form>
    </div>
    <script>
        $("#skills_select").select2();

        $(document).ready(function() {
        //в отдельный JS файл вынести
        
            $('.delete_button').click(function(e){
                let resume_id = e.target.dataset.value;
                console.log(resume_id);
                e.preventDefault();
                if (confirm('Удалить резюме? Все ваши отклики с этим резюме будут отменены')) {
                    $.ajax({
                        url: "{{ url('resume-delete') }}",
                        method: 'post',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "id": resume_id
                        },
                        success: function(result) {
                            // $('#vacancy-container').html(result);
                            
                        }
                    });
                }
            });
        });
    </script>
@endsection

