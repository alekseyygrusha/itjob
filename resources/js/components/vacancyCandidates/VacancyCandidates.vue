<template>
    <div class="candidates-block">
        <div class="block-heading">Подходящие кандидаты</div>
        <div class="loader-box" v-if="showLoader">
            <div class="lds-ripple">
                <div></div>
                <div></div>
            </div>
        </div>
        <template v-else>
            <div class="candidates-filter">
                <template  v-for="filter in filter_items"  :key="filter.code">
                    <div v-if="checkFilterAvailable(filter.code)" class="filter-item button-st"  @click="filterVacancyCandidates(filter.code)"  :class="filter.code === this.filter_code ? '-green' : '-transparent'">
                        {{filter.text}}
                    </div>
                </template>
            </div>
            <div class="candidates-list">
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
                                <div class="salary-box">
                                    <div v-if="candidate.max_salary && candidate.max_salary !== '0' && candidate.min_salary && candidate.min_salary !== '0'">
                                        от {{candidate.min_salary}} до {{candidate.max_salary}} руб.
                                    </div>
                                    <div v-else-if="candidate.max_salary && candidate.max_salary !== '0'">
                                        до {{candidate.max_salary}} руб.
                                    </div>
                                    <div v-else-if="candidate.min_salary  && candidate.min_salary !== '0'">
                                        от {{candidate.min_salary}} руб.
                                    </div>
                                    <div v-else>Уровень дохода не указан</div>
                                </div>

                                <div class="skills-box" v-if="candidate.skills">
                                    <div class="skills-box-item" v-for="skill in candidate.skills" :key="skill.id">{{skill.name}}</div>
                                </div>

                                <div class="button-wrap">
                                    <div v-if="!candidate.is_accept && !candidate.is_rejected" class="button-st -transparent" @click="inviteCandidate(candidate.candidate_id)">Пригласить</div>
                                    <div v-if="!candidate.is_accept && !candidate.is_rejected" @click="declineCandidate(candidate.candidate_id)" class="button-st -transparent -red">Пропустить</div>
                                    <div v-if="candidate.is_accept || candidate.is_rejected" class="button-st  -status" :class="candidate.is_accept ? '-transparent' : '-red'">{{candidate.is_accept ? 'Кандидат приглашён' : 'Пропущен'}}</div>
                                    <div class="button-st -transparent -border-yellow" @click="openResumeCard(candidate.resume_id)">Подробнее</div>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>
                <div v-else>Скоро предложим специалистов подходящих к вашей вакансии</div>
            </div>
        </template>
    </div>
</template>
<script>
import {ajax} from "@/vanilla/ajax.js";
import resumeCard from "../resumeCard/resumeCard.vue";

export default {
    name: "VacancyCandidates",
    props: ['vacancy_id', 'vacancy'],
    mounted() {
        this.filterVacancyCandidates(this.filter_code);
    },
    data() {
        return {
            candidates: [],
            showLoader: true,
            filter_code: 'rating',
            filter_items: {
                rating: {
                    text: 'По рейтингу',
                    code: 'rating',
                    active: false
                },
                salary_rating: {
                    text: 'По совпадению дохода',
                    code: 'salary_rating',
                    active: false
                },
                skills_rating: {
                    text: 'По навыкам',
                    code: 'skills_rating',
                    active: false
                },
                projects_time_experience: {
                    text: 'По опыту в проектах',
                    code: 'projects_time_experience',
                    active: false
                },
            }
        }
    },
    methods: {
        getCandidatesList(data = {}) {
            data.vacancy_id =  this.vacancy_id;
            data.filter = this.filter_code;
            ajax.getVacancyCandidates(data).then((res) => {
                this.candidates = res.data;
                this.showLoader = false;
            });
        },
        checkFilterAvailable(filter_code) {
            if(filter_code === 'salary_rating') {
                return parseInt(this.vacancy.min_salary) || parseInt(this.vacancy.min_salary);
            }

            if(filter_code === 'skills_rating') {
                return this.vacancy.skills.length >= 1
            }

            return true;
        },
        filterVacancyCandidates(filter_code) {
            this.filter_code = filter_code;
            this.getCandidatesList();
        },

        setFilterDefault() {
            //сбрасываем фильтр
            for (let key_filter in this.filter_items) {
                this.filter_items[key_filter].active = false;
            }
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

        inviteCandidate(candidate_id) {
            let data = {
                candidate_id: candidate_id
            };

            ajax.inviteCandidate(data).then((res) => {
                this.getCandidatesList();
            });
        },

        declineCandidate(candidate_id) {
            let data = {
                candidate_id: candidate_id
            };

            ajax.declineCandidate(data).then((res) => {
                this.getCandidatesList();
            });
        }


    }

}
</script>
