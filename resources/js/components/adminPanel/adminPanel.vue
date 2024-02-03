<template>
    <div class="row">
        <div class="col-8">
            <div class="loader-box" v-if="showLoader">
                <div class="lds-ripple">
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="vacancies-container" v-else>
                <div class="vacancies-card" v-for="vacancy in vacancy_list" :key="vacancy.id">
                    <a class="job-title">
                        {{vacancy.job_title}}
                    </a>
                    <div class="company">{{vacancy.company_name}}</div>
                    <div class="city">{{vacancy.city_name}}</div>
                    <div class="description">{{vacancy.description}}</div>

                    <div class="button-wrap">
                        <button class="button-st -green mr-2" v-if="filter.status_code !== 'published'" @click="setVacancyStatus(vacancy.id, 'published')">Разрешить</button>
                        <button class="button-st -red mr-2" v-if="filter.status_code !== 'rejected'" @click="setVacancyStatus(vacancy.id, 'rejected')">Отклонить</button>
                        <div class="button-st -transparent -border-yellow" @click="openVacancyCard(vacancy.id)">Подробнее</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="admin-filter-panel d-flex flex-column col mb-4">
                <template v-for="filter_item in statusFilter" :key="'filter_' + filter_item.code">
                    <div class="filter-item button-st mb-2 " @click="filterByStatus(filter_item.code)" :class="filter_item.code === filter.status_code ? '-green' : '-transparent'">{{filter_item.text}}</div>
                </template>
            </div>
        </div>
    </div>

</template>

<script>
import {ajax} from "@/vanilla/ajax.js";
import vacancyCard from "../vacancyCard/vacancyCard.vue";
import notePanel from "./notePanel/notePanel.vue";
export default {
    props: [],
    data () {
        return {
            showLoader: true,
            filter: {
                type_code: 'vacancy',
                status_code: 'check',
            },
            statusFilter: [
                {
                    code: 'check',
                    text: 'На рассмотрении',
                    active_class: '123'
                },
                {
                    code: 'published',
                    text: 'Опубликованные',
                    active_class: '-green'
                },
                {
                    code: 'rejected',
                    text: 'Отклонённые',
                    active_class: '123'
                },
                {
                    code: 'banned',
                    text: 'Заблокированные',
                    active_class: '123'
                },
            ],

            vacancy_list: {}
        }
    },
    mounted() {
        this.getVacancyList();
    },
    methods: {
        getVacancyList(data = {}) {
            data.status_code = this.filter.status_code;
            data.type_code = this.filter.type_code;

            ajax.getVacancyList(data).then((res) => {
                this.vacancy_list = res.data;
                this.showLoader = false;
            });
        },
        filterByStatus(status_code) {
            this.showLoader = true;
            this.filter.status_code = status_code;

            this.getVacancyList();
        },

        setVacancyStatus(vacancy_id, status_code) {
            ajax.setVacancyStatus({vacancy_id: vacancy_id, status_code: status_code}).then(() => {
                this.getVacancyList();
            });
        },
        openVacancyCard(vacancy_id) {
            this.$modal.show({
                component: vacancyCard,
                bind: {
                    form_code: 'form_code',
                    vacancy_id: vacancy_id,
                },
            });
        },
        openNotePanel(id, panel_type) {
            this.$modal.show({
                component: notePanel,
                bind: {
                    form_code: 'form_code',
                    id: id,
                    panel_type: panel_type
                },
            });
        }

    }
}
</script>
