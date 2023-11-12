<template>
    <div class="filter-vacancy">
        <div class="filter-container">
            <div class="option-row">
                <div class="form-block">
                    <div class="select-input">
                        <selectOptions      
                            placeholder="Выберите город"
                            :options="cities_list" 
                            :multiSelect='true' 
                            @update:option-value="filter.city_ids = $event"></selectOptions>
                    </div>
                </div>
                <div class="form-block">
                    <div class="select-input">
                        <selectOptions      
                            placeholder="Выбери навыки" 
                            :options="skill_list"
                            :multiSelect='true' 
                            @update:option-value="filter.vacancy_skills = $event"></selectOptions>
                    </div>
                </div>
                <div class="form-block mb-0">
                    <div class="input-wrap text-input">
                        <div class="radio-buttons"> 
                            <div v-for="experience_item in experiences_list" v-bind:key="experience_item.id" class="radio-buttons-item" @click="this.filter.expirience_id = experience_item.id" v-bind:class="experience_item.id == filter.expirience_id ? '-active' : ''">
                                {{ experience_item.text }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-block">
                    <div class="filter-button" @click="filterVacancy()">Применить фильтр</div>
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>
    import selectOptions from '../selectOptions/selectOptions.vue';
    import {ajax} from "@/vanilla/ajax.js";
    export default {
        components: {selectOptions},
        props: [
            'skills', 'cities', 'experiences'
        ],
        data() {
            return {
                filter_open: false,
                skill_list: JSON.parse(this.skills),
                cities_list: JSON.parse(this.cities),
                experiences_list: JSON.parse(this.experiences), 
                filter: {
                    vacancy_skills: [],
                    city_ids: [],
                    expirience_id: Number
                }
            }
        },  
        mounted() {
        },
       
        methods: {
            filterVacancy: function () {
                ajax.filterVacancies(this.filter).then((res) => {
                    if(res.data) {
                        
                    } else {
                        
                    }
                    
                });
            }
        }
    }
</script>

   