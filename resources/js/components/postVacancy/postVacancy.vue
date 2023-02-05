<template>
    <div class="post-vacancy">
        <div class="step-container">
            <div class="heading">Введите название должности на вакансию:</div>
            <div class="form-block">
                <div class="input-wrap text-input">
                    <input type="text" value="" placeholder="Full-stack разработчик (Милый котик)">
                </div>
            </div>
            
            <div class="form-block">
                <div class="select-input vue-select-options">
                    <selectOptions     
                        placeholder="Выберите направление" 
                        :options="myOptions" 
                        :option-value="group_id"
                        @update:option-value="group_id = $event"></selectOptions>
                    <input type="hidden"  :value="group_id">
                </div>
            </div>
            <div class="form-block">
                <div class="input-wrap text-input">
                    <input type="text" value="" placeholder="Название компании">
                </div>
            </div>
            <div class="form-block">
                <div class="input-wrap text-input">
                    <selectOptions      
                        placeholder="Выберите город"
                        :options="cities_list" 
                        :option-value="city_id"
                        @update:option-value="city_id = $event"></selectOptions>
                    <input type="hidden"  :value="city_id">
                </div>
            </div>
            <div class="form-block">
                <div class="input-wrap text-input">
                    <div class="row">
                        <div class="col-6">
                            <input type="text" value="" placeholder="ОТ">
                        </div>
                        <div class="col-6">
                            <input type="text" value="" placeholder="ДО">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-block">
                <div class="input-wrap text-input">
                    <textarea name="" placeholder="Описание к вакансии" id="" cols="20" rows="2"></textarea>
                </div>
            </div>
        </div>
    </div> 
</template>

<script>
    import selectOptions from '../selectOptions/selectOptions.vue';
    export default {
        components: {selectOptions},
        props: [
            'cities'
        ],
        data() {
            return {
                cities_list: JSON.parse(this.cities),
                city_id: '',
                group_id: '',
                myValue: '',
                title: '',
                myOptions: [{id: 1, name: "Web"}, {id: 2, name: "Design"}] // or [{id: key, text: value}, {id: key, text: value}]
            }
        },  
        mounted() {
            console.log(this.cities_list);
        },
        methods: {
            show(data) {
                
            },
            myChangeEvent(val){
                console.log(val);
            },
            mySelectEvent({id, text}){
                this.title = text;
            },
            returnSelectContainer(el) {
                
            }
        }
    }
</script>