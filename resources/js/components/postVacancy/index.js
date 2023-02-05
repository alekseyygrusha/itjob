import {createApp} from "vue";
import Vue from 'vue';
import postVacancy from "./postVacancy.vue";

const initPostVacancy = () => {
    let elements = [...document.querySelectorAll('.post-vacancy-form')].filter(
        el => el.dataset.vApp === undefined
    );
 
    if (elements.length) {
        for (let el of elements) {
            createApp({
                components: {
                    postVacancy
                }
            }).mount(el);
        }
        
    }
}

export {initPostVacancy}