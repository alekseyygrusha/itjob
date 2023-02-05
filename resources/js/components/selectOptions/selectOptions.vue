<template>
    <div>
        
        <div class="select-custom" v-bind:class="[open ? 'select-open' : '123']">
            <div class="select-option" @click="openSelect">{{select_option_name ? select_option_name : this.placeholder_data}}</div>
            <div class="list">
                <template v-for="option in options_list" v-bind:key="option.id">
                    <div class="list-option" @click="setOptionId(option.id, option.name)" >
                        {{option.name}}
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['options', 'optionValue', 'placeholder'],
        data() {
            return {
                placeholder_data: this.placeholder ? this.placeholder :  'Выберите значение',
                options_list: this.options,
                open: false,
                set_options_id: Number,
                select_option_name: ''
            }
        },  
        mounted() {
            console.log(this.placeholder_data);
        },
        emits: ['update:optionValue'],
        methods: {
            openSelect () {
                console.log('openSelect');
                if(this.open) {
                    this.open = false;
                    return;
                }
                this.open = true;
            },
            setOptionId(id, name) {
                this.set_options_id = id;
                this.select_option_name = name;
                this.$emit('update:optionValue', this.set_options_id);
                this.open = false;
            }
        }
    }
</script>