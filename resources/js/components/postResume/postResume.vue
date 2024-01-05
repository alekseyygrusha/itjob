<template>
    <form class="resume-form" @submit.prevent="checkForm()">
        <div class="step-container">
            <div class="heading">Заполните данные резюме:</div>
            <div class="form-block">
                <div class="input-wrap text-input">
                    <input type="text"  v-model.trim="form.job_title" :class="v$.form.job_title.$error ? '-error' : ''" placeholder="Full-stack разработчик">
                    <div class="error-wrap">
                        <p v-if="v$.form.job_title.$dirty && v$.form.job_title.maxLength.$invalid">
                            Максимальное количество символов не должно превышать 50.
                        </p>
                        <p v-if="v$.form.job_title.$dirty && v$.form.job_title.minLength.$invalid">
                            Минимальное количество символов 5
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-block">
                <div class="select-input" :class="v$.form.job_group.$error ? '-error' : ''">
                    <selectOptions
                        placeholder="Выберите направление"
                        :options="groups_list"
                        :option="form.job_group"
                        @update:option-value="form.job_group = $event"></selectOptions>
                </div>
            </div>

            <div class="form-block">
                <div class="select-input" :class="v$.form.city_id.$error ? '-error' : ''">
                    <selectOptions
                        placeholder="Выберите город"
                        :options="cities_list"
                        :option="form.city_id"
                        @update:option-value="form.city_id = $event"></selectOptions>
                </div>
            </div>

            <div class="form-block">
                <div class="select-input" >
                    <selectOptions
                        placeholder="Технологии с которыми вы работали"
                        :options="skill_list"
                        :pickOptions="form.skills"
                        :addNewValue='true'
                        :multiSelect='true'
                        @update:option-value="form.skills = $event"></selectOptions>
                </div>
            </div>

            <div class="form-block">
                <temaplate v-if="this.resume">
                    <div class="heading">Проекты в которых вы принимали участие (до 4х):</div>
                    <div class="select-input">
                        <projects-list :projects="this.projects" :skills="this.skills" :resume_id="this.form.resume_id"></projects-list>
                    </div>
                </temaplate>
                <template v-else>
                    <div class="heading -projects-annotate">Добавьте проекты в которых вы участвовали после сохранения резюме</div>
                </template>
            </div>

            <div class="form-block">
                <div class="heading">Желаемая зарплата:</div>
                <div class="input-wrap text-input price-inputs">
                    <div class="row d-flex justify-content-between">
                        <div class="col-6 price-input-wrap">
                            <div class="price-input-wrap">
                                <input type="text" v-model.trim="form.salary_min" @keyup="form.salary_min = transformPrice(form.salary_min)" placeholder="ОТ" >
                            </div>
                        </div>
                        <div class="col-6 ">
                            <div class="price-input-wrap">
                                <input type="text" v-model.trim="form.salary_max" @keyup="form.salary_max = transformPrice(form.salary_max)" placeholder="ДО">
                            </div>

                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input"  @click="alignSalary()" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">Уровнять</label>
                    </div>

                    <div class="error-wrap">
                        <p v-if="!checkSalaryValidate && salary_init">
                            Верхнее значение не должно быть ниже минимального.
                        </p>
                    </div>
                </div>
            </div>
            <div class="form-block">
                <div class="input-wrap text-input">
                    <div class="radio-buttons">
                        <div v-for="experience_item in experiences_list" v-bind:key="experience_item.id" class="radio-buttons-item" @click="this.form.experience_time = experience_item.id" v-bind:class="experience_item.id === form.experience_time ? '-active' : ''">
                            {{ experience_item.text }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-block">
                <div class="input-wrap text-input">
                    <textarea placeholder="Описание к вакансии" v-model.trim="form.description" id="" cols="20" rows="2"></textarea>
                    <div class="error-wrap">
                        <p v-if="v$.form.description.$dirty && v$.form.description.maxLength.$invalid">
                            Размер описание не должен превышать 1000 символов.
                        </p>
                    </div>
                </div>
            </div>

            <div class="input-wrap text-input d-flex">
                <button class="button-st -transparent mr-2" type="submite">Сохранить</button>
                <a v-if="this.resume" class="button-st -border-yellow" @click="deleteResume()">Архивировать</a>
            </div>
        </div>
    </form>
</template>

<script>

import {ajax} from "@/vanilla/ajax.js";
import selectOptions from "../selectOptions/selectOptions.vue";
import {useVuelidate} from "@vuelidate/core";
import {objectsFormat, priceFormat} from "@/mixins/common.mixins";
import ProjectsList from "../Projects/ProjectsList/ProjectsList.vue";
import {maxLength, minLength, required} from "@vuelidate/validators";

export default {
    components: {ProjectsList, selectOptions},
    props: [
        'cities', 'groups', 'resume', 'skills', 'experiences', 'projects'
    ],
    setup () {
        return { v$: useVuelidate() }
    },
    mixins: [objectsFormat, priceFormat],
    validations () {
        return {
            form: {
                job_title: {required, minLength: minLength(5), maxLength: maxLength(50)},
                city_id: {required},
                job_group: {required},
                description: {maxLength: maxLength(1000)}
            }
        }
    },
    data() {

        return {
            groups_list: this.adaptObject(this.groups),
            cities_list: this.cities,
            salary_init: false,
            align_salary: false,
            salary_validate: true,
            skill_list: this.skills,
            experiences_list: this.experiences,
            form: {
                resume_id: this.resume.id ?? '',
                city_id: this.resume.city_id ?? '',
                job_group: this.resume.job_group ?? '',
                job_title: this.resume.job_title ?? '',
                salary_min: this.resume.min_salary ?? '',
                salary_max: this.resume.max_salary ?? '',
                description: this.resume.description ?? '',
                experience_time: this.resume.experience_time ?? 1,
                skills: this.resume.skills ?? [],
            },
        }
    },
    mounted() {
        /*console.log(this.skills);
        console.log('123');
        console.log(this.form.skills);*/
    },
    methods: {
        checkForm() {
            this.v$.form.$touch();
            if(this.v$.form.$dirty && !this.v$.form.$error) {
                this.publicateResume();
            }


        },
        publicateResume() {
            ajax.publicateResume(this.form).then((res) => {
                if(res.status === 200) {
                    alert('Резюме сохранено. Сейчас перенаправим вас в кабинет.');
                    window.location.href = "/cabinet";
                }
            });
        },
        deleteResume() {
            ajax.deleteResume({id: this.form.resume_id}).then(() => {

            });
        },

        checkSalaryValidate() {

            if(parseInt(this.form.salary_min) === 0 && parseInt(this.form.salary_max) === 0) {
                return true;
            }

            if(!this.form.salary_max) {
                return false;
            }

            if(this.align_salary) {
                this.form.salary_min = this.form.salary_max;
            }

            if(!this.form.salary_min) {
                this.form.salary_min = '0';
            }

            let salary_min = parseInt(this.form.salary_min.split(' ').join(''));
            let salary_max = parseInt(this.form.salary_max.split(' ').join(''));
            // console.log(salary_min, salary_max);
            if(salary_min > salary_max) {
                this.salary_validate = false;
                return false;
            }
            this.salary_validate = true;
            return true;
        },


    }
}
</script>
