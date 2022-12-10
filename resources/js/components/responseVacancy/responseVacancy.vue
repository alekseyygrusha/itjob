<template>
    <div class="response-button-wrap">
        <div class="picked-wrap">
            <a class="btn vacansy_response -green-color" @click="toggleResponseMenu()" v-bind:class="[!is_responsed ? 'btn-success' : 'btn-secondary'] ">{{!is_responsed ? 'Откликнуться' : 'Изменить'}}</a>
            <div class="picked-resume">{{picked_resume}}</div>
        </div>
        <div v-if="response_menu_open" class="response-menu"> 
            <div class="close" @click="toggleResponseMenu()">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="resume-wrap">
                <div class="resume-item" v-bind:key="resume.id" v-for="resume in resumes">
                    <div class="resume-title truncate-text truncate-1">
                        {{resume.job_title}}
                    </div>
                    <div class="city">{{resume.city.name}}</div>
                    <div class="experience"> 
                        Опыт: {{resume.experience_time}} год(а)
                    </div>
                    <div class="description truncate-text truncate-2"> 
                        {{resume.description}}
                    </div> 
                    <div @click="chooseResume(resume)" class="pick-resume btn btn-success">Выбрать</div>
                </div>
            </div>
        </div>
    </div>
</template>
 
<script>
    import {ajax} from "@/vanilla/ajax.js";
    
    export default {
        created(){
            console.log('responseVacancy created1');
        },
        mounted() {
            console.log(this.resumes);
        },
        props: {
            resume_list: String, 
            id: String
        },
        data () {
            return {
                is_responsed: false,
                response_menu_open: false,
                resumes: JSON.parse(this.resume_list),
                picked_resume: '',
                vacancy_id: this.id,
            }
        },
        methods: {
            toggleResponseMenu () {
                this.response_menu_open = !this.response_menu_open;
            },
            chooseResume(resume) {
                console.log(resume);
                let data = {
                    resume_id: resume.id,
                    vacancy_id: this.vacancy_id
                };

                ajax.responseVacancy(data).then((res) => {
                    if(res.data.error) {
                        alert(res.data.error);
                        return;
                    }
                    if(res.data) {
                        this.response_menu_open = false;
                        this.is_responsed = true;
                        this.picked_resume = resume.job_title;
                    } else {
                        alert("Произошла ошибка, попробуйте позже");
                    }
                    
                });
            }
        }
    }
</script>
