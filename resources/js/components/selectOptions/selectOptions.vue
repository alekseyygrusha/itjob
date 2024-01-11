<template>
    <div>
        <div v-if="!multiselect" class="select-custom" v-bind:class="[open ? 'select-open' : '']">
            <div class="select-option" @click="openSelect">{{select_option_name ? select_option_name : this.placeholder_data}}</div>
            <div class="list">
                <template v-for="option in options_list" v-bind:key="option.id">
                    <div class="list-option" @click="setOptionId(option.id, option.name)" >
                        {{option.name}}
                    </div>
                </template>
            </div>
        </div>

        <div v-if="multiselect" class="select-custom multi-select" v-bind:class="[open ? 'select-open' : '']">
            <div class="select-options" @click="openSelect">
                <template v-for="option in select_options" v-bind:key="option.id">
                    <div class="select-option-item">
                        {{ option.name }}
                    </div>
                </template>
                <div v-if="!select_options.length" class="select-option">{{ this.placeholder_data }}</div>
            </div>
            <div class="list">
                <template v-if="addNewValue">
                    <div class="select-input -add-item-row">
                        <div class="input-wrap text-input -job_title">
                            <input type="text" placeholder="Начните вводить название">
                            <div class="button-add-wrap">
                                <div class="button-add button-st -transparent">Добавить</div>
                            </div>

                        </div>
                    </div>
                </template>

                <template v-for="option in options_list" v-bind:key="option.id">
                    <div v-bind:class="checkInSelected(option) ? 'option-include' : ''" class="list-option" @click="setMultiOptionId(option)" >
                        <span class="option-text">{{option.name}}</span>
                    </div>
                </template>
            </div>
        </div>

    </div>
</template>

<script>

    export default {
        props: ['options', 'option', 'optionValue', 'placeholder', 'multiSelect', 'pickOptions', 'addNewValue'],
        data() {
            return {
                placeholder_data: this.placeholder ? this.placeholder :  'Выберите значение',
                options_list: this.options,
                open: false,
                set_options_id: Number,
                select_option_name: '',
                multiselect: this.multiSelect ?? false,
                select_options: this.pickOptions ?? []

            }
        },
        mounted() {
            if(this.option) {
                let pick_option = this.options_list.find(item => item.id === this.option);
                this.setOptionId(pick_option.id, pick_option.name);
            }
        },
        emits: ['update:optionValue'],
        methods: {
            openSelect () {
                if(this.open) {
                    this.open = false;
                    return;
                }
                this.open = true;
            },
            setOptionId(id, name) {
                this.set_options_id = id;
                this.select_option_name = name;
                this.$emit('update:optionValue', this.set_options_id );
                this.open = false;
            },
            checkInSelected(select_option) {
                return this.select_options.find(option => option.id === select_option.id);
            },
            setMultiOptionId(select_option) {
                let find_in_select = this.checkInSelected(select_option);
                if(find_in_select) {
                    let option_index = this.select_options.indexOf(find_in_select);
                    console.log(option_index);
                    this.select_options.splice(option_index, 1);
                } else {
                    this.select_options.push(select_option);
                }

                console.log(this.select_options);
                // у нас сразу приходит готовый объект с именем и id. Надо тогда им и манипулировать



                // if(this.select_options.includes(id)) {
                //     let option_index = this.select_options.indexOf(id);
                //     this.select_options.splice(option_index, 1);

                // } else {
                //     this.select_options.push(id);
                // }
                this.$emit('update:optionValue', this.select_options);
            },
        }
    }
</script>
