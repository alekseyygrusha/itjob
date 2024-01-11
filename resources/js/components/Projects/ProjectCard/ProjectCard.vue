<template>
    <vue-final-modal
        :name="modalName"
        v-model="showModal"
        classes="modal-container"
        content-class="modal-content project-card"
    >
        <div class="loader-box" v-if="showLoader">
            <div class="lds-ripple">
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="inner-content" v-else>
            <div class="form-block">
                <div class="heading">Укажите название проекта:</div>
                <div class="select-input">
                    <div class="input-wrap text-input">
                        <input type="text" v-model="project_form.title" placeholder="Разработка интернет-магазина">
                    </div>
                </div>
            </div>

            <div class="form-block">
                <div class="heading">Должность:</div>
                <div class="select-input">
                    <div class="input-wrap text-input -job_title">
                        <input type="text" v-model="project_form.job_title" placeholder="Backend-разработчик">
                    </div>
                </div>
            </div>

            <div class="form-block">
                <div class="select-input" >
                    <selectOptions
                        placeholder="Технологии с которыми вы работали"
                        :options="this.skills"
                        :pickOptions="this.skills_project"
                        :addNewValue='true'
                        :multiSelect='true'
                        @update:option-value="this.skills_project = $event"></selectOptions>
                </div>
            </div>
            <div class="form-block">
                <div class="heading">Описание:</div>
                <div class="input-wrap text-input">
                    <textarea v-model="project_form.description" placeholder="Опишите подробнее чем занимались в рамках проекта, что нового узнали или какие навыки укрепили"  id="" cols="20" rows="4"></textarea>
                    <div class="error-wrap">
                        <!--                        <p v-if="v$.form.description.$dirty && v$.form.description.maxLength.$invalid">
                                                    Размер описание не должен превышать 1000 символов.
                                                </p>-->
                    </div>
                </div>
            </div>
            <div class="footer">
                <div class="row">
                    <div class="col-4">
                        <div class="form-block">
                            <div class="heading">Длительность (мес.):</div>
                            <div class="select-input">
                                <div class="input-wrap text-input">
                                    <input type="text" v-model="project_form.time_months"  placeholder="В месяцах">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-block">
                            <div class="heading">Название компании:</div>
                            <div class="select-input">
                                <div class="input-wrap text-input">
                                    <input type="text" v-model="project_form.company_name" placeholder="Например: Microsoft">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="buttons-wrap">
                <div class="button-st -transparent mr-2" @click="saveProject()">Сохранить</div>
                <div v-if="this.id" class="button-st -border-yellow" @click="unbindResumeProject()">Отвязать</div>
            </div>
        </div>
    </vue-final-modal>
</template>
<script>
import {ajax} from "@/vanilla/ajax.js";

import SelectOptions from "../../selectOptions/selectOptions.vue";
export default {
    name: "MessagePopup",
    components: {SelectOptions},
    props: ['form_code', 'id', 'resume_id', 'skills'],

    mounted() {

        this.loadProjectDada();
    },
    data() {
        return {
            showModal: false,
            modalName: this.form_code,
            showLoader: true,
            project_form: {
                id: '',
                company_name: '',
                description: '',
                job_title: '',
                skills: [],
                time_months: '',
                title: '',
                user_id: ''
            },
            skills_project: []
        }
    },
    methods: {
        loadProjectDada() {

          if(this.id) {
              ajax.getProject({id: this.id, resume_id: this.resume_id}).then((res) => {
                  if(res.data) {
                      this.project_form = res.data;
                      this.project_form.resume_id = this.resume_id;
                      this.showLoader = false;

                        if(res.data.skills.length) {
                            // хитрое решение для того сохранить реактивность
                            res.data.skills.forEach(el => {
                                this.skills_project.push(el);
                            })
                        }
                  }
              });
          } else {
              this.showLoader = false;
          }
        },
        closeModal() {
            this.$vfm.hide(this.modalName);
        },
        saveProject() {
            this.project_form.resume_id = this.resume_id;
            console.log(this.project_form)
            ajax.saveProject(this.project_form).then((res) => {
                if(res.status === 200) {
                    //дёргаем перерисовку списка проектов
                    this.$emit('updateList');
                    this.closeModal();
                }
            });

        },
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
        }

    },
}
</script>
