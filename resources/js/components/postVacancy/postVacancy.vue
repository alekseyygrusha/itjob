<template>
    <div class="post-vacancy">
        <div class="step-container">
            <div class="heading">Заполните данные резюме:</div>
            <div class="form-block">
                <div class="input-wrap text-input">
                    <input type="text" value="" placeholder="Full-stack разработчик (Милый котик)">
                </div>
            </div>
            
            <div class="form-block">
                <div class="select-input vue-select-options">
                    <selectOptions     
                        placeholder="Выберите направление" 
                        :options="groups_list" 
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
            <div class="d-flex justify-content-center">
                <div class="button publicate -green-color">Опубликовать</div>
            </div>
        </div>
    </div> 
</template>

<script>
    import selectOptions from '../selectOptions/selectOptions.vue';
    export default {
        components: {selectOptions},
        props: [
            'cities', 'groups'
        ],
        data() {
            return {
                cities_list: JSON.parse(this.cities),
                city_id: '',
                group_id: '', 
                myValue: '',
                title: '',
                groups_list: this.adaptObject(JSON.parse(this.groups)),
            }
        },  
        mounted() {
            // this.groups_list = this.adaptObject(this.groups_list);

            console.log(this.groups_list);
        },
        methods: {
            adaptObject(obj) {
                return obj.map(function (obj) {
                    return {'id': obj.id, 'name': obj.group_name};
                });
            },
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
