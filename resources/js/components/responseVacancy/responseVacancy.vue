<template>
    <div class="response-button-wrap">
        <div class="picked-wrap">
            <a v-if="!this.responsed_resume_id" class="btn vacansy_response -green-color btn-success" @click="toggleResponseMenu()" >Откликнуться</a>
            <div v-else class="btn vacansy_response -green-color btn-secondary" @click="toggleResponseMenu()" >Отклик отправлен</div>
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
                    <div v-if="parseInt(resume.id) !== this.responsed_resume_id" @click="chooseResume(resume)" class="pick-resume btn" v-bind:class="[!responsed_resume_id ? 'btn-success' : 'btn-secondary'] ">Выбрать</div>
                    <div v-else class="pick-resume btn btn-success" >Отправлено</div>
                </div>
            </div>
        </div>
        <!-- Надо будет добавить условие, при котором предлагается создать резюме при его отсуствии.  -->
    </div>
</template>
 
<script>
    import {ajax} from "@/vanilla/ajax.js";
    
    export default {
        created(){
            console.log('responseVacancy created1');
        },
        mounted() {
            this.setResponsedVacancyTitle();
        },
        props: {
            resume_list: String, 
            id: String,
            responsed_id: String
        },
        data () {
            return {
                responsed_resume_id: parseInt(this.responsed_id),
                response_menu_open: false,
                resumes: JSON.parse(this.resume_list),
                picked_resume: '',
                vacancy_id: this.id,
            }
        },
        methods: {
            setResponsedVacancyTitle() {
                if(this.responsed_resume_id) {
                    this.picked_resume = this.resumes.find(resume => resume.id === this.responsed_resume_id).job_title;
                }
            },
            toggleResponseMenu () {
                this.response_menu_open = !this.response_menu_open;
            },
            isResponsed(){                
                return this.responsed_resume_id ? true : false;
            },
            chooseResume(resume) {
                if(this.responsed_resume_id) {
                    return;
                }
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
                        this.picked_resume = resume.job_title;
                        this.responsed_resume_id = resume.id;
                    } else {
                        alert("Произошла ошибка, попробуйте позже");
                    }
                    
                });
            },
            cancelResponseResume(resume) {
                let data = {
                    resume_id: resume.id,
                    vacancy_id: this.vacancy_id
                };
                
                ajax.cancelResponseVacancy(data).then((res) => {
                    if(res.data) {
                        this.responsed_resume_id = null;
                        this.picked_resume = null;
                    } else {
                        alert("Произошла ошибка, попробуйте позже");
                    }
                });
            }
        }
    }
</script>
