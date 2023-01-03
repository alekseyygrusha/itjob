import {createApp} from "vue";
import Vue from 'vue'
import responseResume from "./responseResume.vue";
const initResponseResume = () => {
    let elements = [...document.querySelectorAll('.vue-response-resume')].filter(
        el => el.dataset.vApp === undefined
    );

    if (elements.length) {
        for (let el of elements) {
            createApp({
                name: 'ResponseResumeApp',
                components: {
                    responseResume
                }
            }).mount(el);
        }
        
    }
    
}

export {initResponseResume};