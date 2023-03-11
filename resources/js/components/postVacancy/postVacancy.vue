<template>
    <form class="post-vacancy" @submit.prevent="checkForm()">
        <div class="step-container">
            <div class="heading">Заполните данные вакансии:</div>
            <div class="form-block">
                <div class="input-wrap text-input">
                    <input type="text" :class="v$.form.job_title.$error ? '-error' : ''" v-model.trim="form.job_title"  placeholder="Full-stack разработчик (Милый котик)">
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
                        @update:option-value="form.city_id = $event"></selectOptions>
                </div>
            </div>
            <div class="form-block">
                <div class="heading">Зарплатная вилка:</div>
                <div class="input-wrap text-input">
                    <div class="row">
                        <div class="col-6">
                            <input type="text" v-model.trim="form.salary_min" :class="v$.form.salary_min.$error ? '-error' : ''" placeholder="ОТ">
                        </div>
                        <div class="col-6">
                            <input type="text" v-model.trim="form.salary_max" :class="v$.form.salary_max.$error ? '-error' : ''" placeholder="ДО">
                        </div>
                    </div>
                    <div class="error-wrap">
                        <p v-if="v$.form.salary_min.$dirty && v$.form.salary_min.maxValue.$invalid">
                            Нижняя граница не должна превышать значение верхней.
                        </p>
                        <p v-if="v$.form.salary_max.$dirty && v$.form.salary_max.minValue.$invalid">
                            Верхнее значение не должно быть ниже минимального.
                        </p>
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
            <div class="d-flex justify-content-center">
                <button class="button publicate -green-color" type="submite">Опубликовать</button>
            </div>
        </div>
    </form> 
</template>

<script>
    import { useVuelidate } from '@vuelidate/core'
    import { required, email, minLength , maxLength, integer, maxValue, minValue} from '@vuelidate/validators'
    import selectOptions from '../selectOptions/selectOptions.vue';
    import {ajax} from "@/vanilla/ajax.js";
    export default {
        components: {useVuelidate, selectOptions},
        props: [
            'cities', 'groups'
        ],
        setup () {
            return { v$: useVuelidate() }
        },
        data() {
            
            return {
                groups_list: this.adaptObject(JSON.parse(this.groups)),
                cities_list: JSON.parse(this.cities),
                form: {
                    city_id: '',
                    group_id: '', 
                    job_title: '',
                    salary_min: '',
                    salary_max: '',
                    company_name: '',
                    description: ''
                }
            }
        },
        validations () {
            return {
                form: {
                    job_title: {required, minLength: minLength(5), maxLength: maxLength(50)},
                    city_id: {required},
                    group_id: {required},
                    company_name: {required, minLength: minLength(1), maxLength: maxLength(100)},
                    salary_min: {integer, maxValue: maxValue(parseInt(this.form.salary_max))},
                    salary_max: {integer, minValue: minValue(parseInt(this.form.salary_min))},
                    description: {maxLength: maxLength(1000)}
                }
            }
        },
        methods: {
            checkForm() {
                this.v$.form.$touch();
                if(this.v$.form.$dirty && !this.v$.form.$error) {
                    this.publicateVacancy();
                }
            },
            adaptObject(obj) {
                return obj.map(function (obj) {
                    return {'id': obj.id, 'name': obj.group_name};
                });
            },

            publicateVacancy() {      
                ajax.publicateVacancy(this.form).then((res) => {
                    console.log(res);
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
