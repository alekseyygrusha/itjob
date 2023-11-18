<template>
    <form class="resume-form" @submit.prevent="checkForm()">
        <div class="step-container">
            <div class="heading">Заполните данные резюме:</div>
            <div class="form-block">
                <div class="input-wrap text-input">
                    <input type="text" v-model.trim="form.job_title"  placeholder="Full-stack разработчик">
                    <div class="error-wrap">
<!--                        <p v-if="v$.form.job_title.$dirty && v$.form.job_title.maxLength.$invalid">
                            Максимальное количество символов не должно превышать 50.
                        </p>
                        <p v-if="v$.form.job_title.$dirty && v$.form.job_title.minLength.$invalid">
                            Минимальное количество символов 5
                        </p>-->
                    </div>
                </div>
            </div>

            <div class="form-block">
                <div class="select-input" >
                    <selectOptions
                        placeholder="Выберите направление"
                        :options="groups_list"
                        :option="form.job_group"
                        @update:option-value="form.job_group = $event"></selectOptions>
                </div>
            </div>

            <div class="form-block">
                <div class="select-input">
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
                        placeholder="Укажите ваши навыки"
                        :options="skill_list"
                        :pickOptions="form.skills"
                        :multiSelect='true'
                        @update:option-value="form.skills = $event"></selectOptions>
                </div>
            </div>

            <div class="form-block">
                <div class="heading">Желаемая зарплата:</div>
                <div class="input-wrap text-input price-inputs">
                    <div class="row d-flex justify-content-between">
                        <div class="col-6 price-input-wrap">
                            <div class="price-input-wrap">
                                <input type="text" v-model.trim="form.salary_min" @keyup="form.salary_min = transformPrice(form.salary_min)" placeholder="ОТ" :disabled="align_salary ? '' : disabled">
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
<!--                        <p v-if="v$.form.description.$dirty && v$.form.description.maxLength.$invalid">
                            Размер описание не должен превышать 1000 символов.
                        </p>-->
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button class="button publicate -green-color" type="submite">Опубликовать</button>
                <button class="publucate-button delete_button button -red-color ml-4" @click="deleteResume()">Архивировать</button>
            </div>


        </div>
    </form>
</template>

<script>

import {ajax} from "@/vanilla/ajax.js";
import selectOptions from "../selectOptions/selectOptions.vue";
import {useVuelidate} from "@vuelidate/core";
import {objectsFormat} from "@/mixins/common.mixins";
export default {
    components: {selectOptions},
    props: [
        'cities', 'groups', 'resume', 'skills', 'experiences'
    ],
    setup () {
        return { v$: useVuelidate() }
    },
    mixins: [objectsFormat],
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
        console.log(this.resume);
        console.log(this.form)
        console.log(this.cities);
        console.log(this.groups);
        console.log(this.resume);
        console.log(this.skills);
        console.log(this.experiences);
    },
    methods: {
        checkForm() {
            /*this.v$.form.$touch();
            if(this.v$.form.$dirty && !this.v$.form.$error) {

            }*/
            console.log("publicateResume");
            console.log(this.form);
            this.publicateResume();
        },
        publicateResume() {
            console.log("publicateResume");
            console.log(this.form);
            ajax.publicateResume(this.form).then(() => {


            });
        },
        deleteResume() {
            ajax.deleteResume({id: this.form.resume_id}).then(() => {


            });
        }

    }
}
</script>
