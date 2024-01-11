<template>
    <form class="post-vacancy" @submit.prevent="checkForm()">
        <div class="step-container">
            <div class="heading">Заполните данные вакансии:</div>
            <div class="form-block">
                <div class="input-wrap text-input">
                    <input type="text" :class="v$.form.job_title.$error ? '-error' : ''" v-model.trim="form.job_title"  placeholder="Full-stack разработчик">
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
                <div class="select-input" :class="v$.form.group_id.$error ? '-error' : ''">
                    <selectOptions
                        placeholder="Выберите направление"
                        :options="groups_list"
                        :option="form.group_id"
                        @update:option-value="form.group_id = $event"></selectOptions>
                </div>
            </div>
            <div class="form-block">
                <div class="input-wrap text-input">
                    <input type="text" :class="v$.form.company_name.$error ? '-error' : ''" v-model.trim="form.company_name" placeholder="Название компании">
                    <div class="error-wrap">
                        <p v-if="v$.form.company_name.$dirty && v$.form.company_name.maxLength.$invalid">
                            Максимальное количество символов не должно превышать 100.
                        </p>
                        <p v-if="v$.form.company_name.$dirty && v$.form.company_name.minLength.$invalid">
                            Минимальное количество символов 1
                        </p>
                    </div>

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
                        placeholder="Требуемые навыки"
                        :options="skill_list"
                        :pickOptions="form.vacancy_skills"
                        :addNewValue='true'
                        :multiSelect='true'
                        @update:option-value="form.vacancy_skills = $event"></selectOptions>
                </div>
            </div>

            <div class="form-block">
                <div class="heading">Зарплатная вилка:</div>
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
                        <div v-for="experience_item in experiences_list" v-bind:key="experience_item.id" class="radio-buttons-item" @click="pickExpirience(experience_item.id)" v-bind:class="experience_item.id === form.expirience_id ? '-active' : ''">
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
                <button class="button-st -transparent mr-2" type="submite">Опубликовать</button>
                <a class="button-st -border-yellow" @click="deleteVacancy()">Архивировать</a>
            </div>
        </div>
    </form>
</template>

<script>
    import { useVuelidate } from '@vuelidate/core'
    import { required, email, minLength , maxLength, integer, maxValue, minValue} from '@vuelidate/validators'
    import selectOptions from '../selectOptions/selectOptions.vue';
    import {ajax} from "@/vanilla/ajax.js";
    import {objectsFormat, priceFormat} from "@/mixins/common.mixins";

    export default {
        components: {selectOptions},
        props: [
            'cities', 'groups', 'vacancy', 'skills', 'experiences'
        ],
        setup () {
            return { v$: useVuelidate() }
        },
        mixins: [objectsFormat, priceFormat],
        data() {
            let vacancy_data = this.vacancy ? JSON.parse(this.vacancy) : {};

            return {
                groups_list: this.adaptObject(JSON.parse(this.groups)),
                cities_list: JSON.parse(this.cities),
                salary_init: false,
                align_salary: false,
                salary_validate: true,
                skill_list: JSON.parse(this.skills),
                experiences_list: JSON.parse(this.experiences),
                form: {
                    id: vacancy_data.id ?? '',
                    city_id: vacancy_data.city ?? '',
                    group_id: vacancy_data.job_group ?? '',
                    job_title: vacancy_data.job_title ?? '',
                    salary_min: vacancy_data.min_salary ?? '',
                    salary_max: vacancy_data.max_salary ?? '',
                    company_name: vacancy_data.company_name ?? '',
                    description: vacancy_data.description ?? '',
                    expirience_id: vacancy_data.expirience_id ?? 1,
                    vacancy_skills: vacancy_data.skills ?? [],
                },
            }
        },

        validations () {
            return {
                form: {
                    job_title: {required, minLength: minLength(5), maxLength: maxLength(50)},
                    city_id: {required},
                    group_id: {required},
                    company_name: {required, minLength: minLength(1), maxLength: maxLength(100)},
                    description: {maxLength: maxLength(1000)}
                }
            }
        },
        mounted () {
        },
        computed: {
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

        },
        methods: {
            alignSalary() {
                console.log('alignSalary');
                this.align_salary = !this.align_salary;

            },
            pickExpirience(id) {
                this.form.expirience_id = id;
            },
            deleteVacancy() {
                ajax.deleteVacancy({id: this.form.id}).then(() => {


                });
            },
            checkForm() {
                this.v$.form.$touch();
                if(this.v$.form.$dirty && !this.v$.form.$error) {
                    this.publicateVacancy();
                }
            },
            publicateVacancy() {
                console.log(this.form)
                ajax.publicateVacancy(this.form).then((res) => {
                    console.log(res.data.answer);
                    if(res.data.answer) {
                        alert('Вакансия была опубликована. Сейчас перенаправим вас в кабинет.');
                        window.location.href = "/cabinet";
                    }
                });
            }

        }
    }
</script>

<style scoped>
    .publicate {
        height: auto;
        padding: 7px 35px;
        line-height: 30px;
        border-radius: 4px;
    }
</style>
