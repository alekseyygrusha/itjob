<template>
    <div class="candidates-block">
        <div class="block-heading">Подходящие кандидаты</div>
        <div class="loader-box" v-if="showLoader">
            <div class="lds-ripple" >
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="candidates-list" v-else>
            <template v-if="candidates.length">
                <template v-for="candidate in candidates" :key="candidate.candidate_id">
                    <div class="info-box candidates-list-item">
                        <div class="content">
                            <div class="content-item name"><b>Иванов Иван Иванович</b></div>
                            <a class="job-title resume-title">
                                {{candidate.job_title}} {{candidate.id}}
                            </a>
                            <div class="content-item city">{{candidate.city_name}}</div>
                            <div class="content-item experience">
                                Общий опыт: {{candidate.experience_time}} год(a)
                            </div>

                            <div class="skills-box" v-if="candidate.skills">
                                <div class="skills-box-item" v-for="skill in candidate.skills" :key="skill.id">{{skill.name}}</div>
                            </div>

                            <div class="button-wrap">
                                <div v-if="!candidate.is_accept && !candidate.is_rejected" class="button-st -transparent" @click="inviteCandidate(candidate.candidate_id, candidate.resume_id)">Пригласить</div>
                                <div v-if="!candidate.is_accept && !candidate.is_rejected" class="button-st -transparent -red">Пропустить</div>
                                <div v-if="candidate.is_accept || candidate.is_rejected" class="button-st  -status" :class="candidate.is_accept ? '-transparent' : '-red'">{{candidate.is_accept ? 'Кандидат приглашён' : 'Пропущен'}}</div>
                                <div class="button-st -transparent -border-yellow" @click="openResumeCard(candidate.resume_id)">Подробнее</div>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
            <div v-else>Скоро предложим специалистов подходящих к вашей вакансии</div>
        </div>
    </div>
</template>
<script>
import {ajax} from "@/vanilla/ajax.js";
import resumeCard from "../resumeCard/resumeCard.vue";

export default {
    name: "VacancyCandidates",
    props: ['vacancy_id'],
    mounted() {
        this.getCandidatesList();
    },
    data() {
        return {
            candidates: [],
            showLoader: true
        }
    },
    methods: {
        getCandidatesList() {
            console.log('getCandidatesList');
            console.log(this.vacancy_id);
            ajax.getVacancyCandidates({vacancy_id: this.vacancy_id}).then((res) => {
                this.candidates = res.data;
                this.showLoader = false;
            });
        },

        openResumeCard(resume_id) {
            let self = this; //костыль для сохранения контекста
            console.log(resume_id)
            this.$modal.show({
                component: resumeCard,
                bind: {
                    form_code: 'form_code',
                    resume_id: resume_id,
                },
                on: {
                    updateList() {
                        /*self.getProjectsList();*/
                    },
                },
            });
        },

        inviteCandidate(candidate_id, resume_id) {
            let data = {
                candidate_id: candidate_id,
                resume_id: resume_id,
            };

            ajax.inviteCandidate(data).then((res) => {
                console.log(this.candidates);
            });
        },

        declineCandidate(candidate_id) {
            let data = {
                candidate_id: candidate_id
            };

            ajax.declineCandidate(data).then((res) => {});
        }


    }

}
</script>
