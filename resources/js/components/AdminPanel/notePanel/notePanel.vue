<template>
    <vue-final-modal
        :name="modalName"
        v-model="showModal"
        classes="modal-container"
        content-class="modal-content vacancy-card-form"
    >

        <div>

        </div>
    </vue-final-modal>
</template>

<script>
export default {
    name: "notePanel",
    props: ['id', 'panel_type'],

    mounted() {

    },
    data() {
        return {


        }
    },
    methods: {
    },
}
</script>
