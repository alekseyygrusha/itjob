<template>
    <vue-final-modal
        :name="modalName"
        v-model="showModal"
        classes="modal-container"
        content-class="modal-content resume-card"
    >
        <div class="loader-box" v-if="showLoader">
            <div class="lds-ripple" >
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="resume-card" v-else>
            <div class="row">
                <div class="col-7">
                    <div class="info-box">
                        <div class="content">
                            <div class="content-item -name">Жмышенко Валерий Альбертович</div>
                            <div class="content-item -title">{{resume.job_title}}</div>
                            <div class="content-item -exp">Опыт работы: {{resume.experience.text}}</div>
                            <div class="content-item -city">{{resume.city.name}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="info-box">
                        <div class="block-heading">Технологии</div>
                        <div class="skills-box">
                            <div class="skills-box-item" v-for="skill in resume.skills">{{ skill.name }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="info-box description-block">
                        <div class="block-heading">О себе</div>
                        <div class="description">
                            {{resume.description}}
                        </div>
                    </div>
                    <div class="info-box" v-if="projects">
                        <div class="block-heading">Опыт в проектах</div>
                        <div class="projects-container">
                            <div class="projects-list">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="projects-item" v-for="project in projects">
                                            <div class="-title">{{project.title}}</div>
                                            <div class="content">
                                                <div class="content-item -job-title">{{project.job_title}}</div>
                                                <div class="skills-list">
                                                    <div class="skill-item" v-for="skill in JSON.parse(project.skills)">
                                                        {{skill.name}}
                                                    </div>
                                                </div>
                                                <div class="content-item -description">{{project.description}}</div>
                                            </div>
                                            <div class="footer">
                                                <span class="duration">{{project.time_months}} месяцев</span>
                                                <span class="company">{{project.company_name}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </vue-final-modal>
</template>
<script>
import {ajax} from "@/vanilla/ajax.js";

export default {
    name: "resumeCard",
    props: ['resume_id'],

    mounted() {
        this.getResumeData();
    },
    data() {
        return {
            showModal: false,
            modalName: this.form_code,
            showLoader: true,
            resume: {
                experience: '',
                city: ''
            },
            projects: {}
        }
    },
    methods: {
        getResumeData () {
            ajax.getResume({resume_id: this.resume_id}).then((res) => {
                this.resume = res.data.resume;
                this.projects = res.data.projects;
                this.showLoader = false;
                console.log(this.resume);
                console.log(this.projects);
            });
        },

    },
}
</script>
