<template>
    <vue-final-modal
        :name="modalName"
        v-model="showModal"
        classes="modal-container"
        content-class="modal-content add-skill-modal"
    >
    <div>
        <p>Мы добавим указанный вами навык как только он пройдёт проверку</p>
        <div class="input-wrap text-input">
            <input type="text" v-model.trim="skill_name" placeholder="Введите название навыка">
        </div>
        <div>
            <a class="button-st -transparent" @click="addSkill()">Добавить</a>
        </div>
    </div>
    </vue-final-modal>
</template>
<script>
import {ajax} from "@/vanilla/ajax.js";

export default {
    name: "addSkillModal",
    components: {},
    props: ['name'],
    data() {
        return {
            showModal: false,
            modalName: this.form_code,
            skill_name: this.name
        }
    },
    mounted() {
        console.log(this.skill_name);
    },

    methods: {
        unbindResumeProject() {
            ajax.deleteProjectResume({id: this.project_form.id}).then((res) => {


                if(res.status === 200) {
                    console.log("test 200");
                    this.$emit('updateList');
                    this.closeModal();
                } else {
                    alert('Ошибка');
                }
            });
        },
        addSkill() {
            this.$emit('addSkill');
        }

    },
}
</script>
