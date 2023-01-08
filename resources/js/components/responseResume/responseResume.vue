<template>
    <div v-if="this.isChecked" class="button-wrap">
        <template v-if="this.isAccept">
            <div class="button vacansy_response -color-blue">Перейти в чат</div>
            <div>Отклик принят</div>
        </template>
        <template v-else>
            Вы отклонили кандитата
        </template>
    </div>
    <div v-else class="button-wrap">
        <div class="button vacansy_response -green-color btn-success" @click="acceptResponseVacancy()">Принять</div>
        <div class="button btn-warning btn-hide" @click="declineResponseVacancy()">Отклонить</div>
    </div>
</template>

<script>
    import {ajax} from "@/vanilla/ajax.js";
    export default {
        props: ['response_id', 'is_accept', 'is_checked'],
        data () {
            return {
                responseId: this.response_id,
                isAccept: Number(this.is_accept),
                isChecked: Number(this.is_checked),
            }
        }, 
        mounted() {
        },
        methods: {
          
            acceptResponseVacancy() {
                let data = {
                    response_id: this.responseId,
                };
                ajax.acceptResponseVacancy(data).then((res) => {
                    if(res.data.error) {
                        alert(res.data.error);
                        return;
                    }
                    if(res.data) {
                        this.isChecked = true;
                        this.isAccept = true;
                    } else {
                        alert("Произошла ошибка, попробуйте позже");
                    }
                    
                });
            },

            declineResponseVacancy() {
                let data = {
                    response_id: this.responseId,
                };
                ajax.declineResponseVacancy(data).then((res) => {
                    if(res.data.error) {
                        alert(res.data.error);
                        return;
                    }
                    if(res.data) {
                        
                        this.isAccept = false;
                        this.isChecked = true;
                        
                    } else {
                        alert("Произошла ошибка, попробуйте позже");
                    }
                    
                });
            },
        }
    }
</script>