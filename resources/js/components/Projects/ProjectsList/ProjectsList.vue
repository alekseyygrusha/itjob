<template>
    <div class="projects-container">
        <div class="projects-list">
            <div class="row">
                <template v-if="Object.keys(this.projects_list).length">
                    <template v-for="project in projects_list">
                        <div class="col-6">
                            <div class="projects-item" @click="openProjectsCard(project.id)">
                                <div class="-title">{{project.title}}</div>
                                <div class="content">
                                    <div class="content-item -job-title">{{project.job_title}}</div>
                                    <div class="skills-list">
                                        <div class="skill-item" v-for="skill in JSON.parse(project.skills)">
                                            {{skill}}
                                        </div>
                                    </div>
                                    <div class="content-item -description">{{project.description && project.description.length > 100 ? project.description.slice(0 , 100) + '...' : project.description}}</div>
                                </div>
                                <div class="footer">
                                    <span class="duration">{{project.time_months}} месяцев</span>
                                    <span class="company">{{project.company_name}}</span>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="col-6" v-if="Object.keys(projects_list).length % 2 !== 0 && Object.keys(projects_list).length <= 4">
                        <div class="projects-item -add-project" @click="openProjectsCard()">
                            <div class="content">
                                <span>Добавить проект</span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <div class="add-project button-st -transparent" v-if="Object.keys(projects_list).length % 2 === 0 && Object.keys(projects_list).length <= 4" @click="openProjectsCard()">
            <span>Добавить проект</span>
        </div>
    </div>
</template>

<script>
import {ajax} from "@/vanilla/ajax.js";
import ProjectCard from "../ProjectCard/ProjectCard.vue";
export default {
    props: ['projects', 'resume_id'],
    data () {
        return {
            projects_list: this.projects
        }
    },
    mounted() {
        console.log(this.projects_list)
    },
    methods: {
        openProjectsCard(id = null) {
            let self = this; //костыль для сохранения контекста
            console.log(this.resume_id);
            console.log("openProjectsCard");
            this.$modal.show({
                component: ProjectCard,
                bind: {
                    form_code: 'form_code',
                    messageTest: '',
                    id: id,
                    resume_id: this.resume_id
                },
                on: {
                    updateList() {
                        console.log("123123");
                        self.getProjectsList();
                    },
                },
            },);
        },
        getProjectsList() {
            ajax.getProjectsList({id: this.resume_id}).then((res) => {
                this.projects_list = res.data;
            });
        }
    }
}
</script>
