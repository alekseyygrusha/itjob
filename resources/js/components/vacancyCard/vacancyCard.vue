<template>
    <vue-final-modal
        :name="modalName"
        v-model="showModal"
        classes="modal-container"
        content-class="modal-content vacancy-card-form"
    >
        <div class="loader-box" v-if="showLoader">
            <div class="lds-ripple" >
                <div></div>
                <div></div>
            </div>
        </div>
        <div v-else>
            <div class="vacancy-card">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="info-box">
                                <div class="content">
                                    <div class="content-item -title">{{vacancy.job_title}}</div>
                                    <div class="content-item -exp">Опыт работы: {{vacancy.experience.text}}</div>
                                    <div class="content-item -company">{{vacancy.company_name}}</div>
                                    <div class="content-item -city">{{vacancy.bind_city.name}}</div>
                                </div>
                            </div>
                            <div class="main-description">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="info-box description-block">
                                            <div class="block-heading">Технологии</div>
                                            <div class="skills-box" v-if="vacancy.skills.length">
                                                <div class="skills-box-item" :key="'skill_' + skill.id" v-for="skill in vacancy.skills">{{skill.name}}</div>
                                            </div>
                                            <div v-else class="skill-note">Навыки не указаны</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="info-box description-block">
                                            <div class="block-heading">Описание вакансии</div>
                                            <div class="description">
                                                {{vacancy.description}}
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
    props: ['vacancy_id'],

    mounted() {
        this.getResumeData();
    },
    data() {
        return {
            showModal: false,
            modalName: this.form_code,
            showLoader: true,
            vacancy: {
                bind_city: String
            },

        }
    },
    methods: {
        getResumeData () {
            ajax.getVacancy({vacancy_id: this.vacancy_id}).then((res) => {
                this.vacancy = res.data;
                this.showLoader = false;
            });
        },

    },
}
</script>
