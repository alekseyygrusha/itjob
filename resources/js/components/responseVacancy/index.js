import {createApp} from "vue";
import Vue from 'vue'
import responseVacancy from "./responseVacancy.vue";
const initResponseVacancy = () => {
    let elements = [...document.querySelectorAll('.vue-response-vacancy')].filter(
        el => el.dataset.vApp === undefined
    );
    
    if (elements.length) {
        for (let el of elements) {
            console.log(el);
            createApp({
                name: 'ResponseVacancyApp',
                components: {
                    responseVacancy
                }
            }).mount(el);

            // new Vue({
            //     el,
            //     components: {
            //         responseVacancy
            //     },
            // });

            
    
            // app.mount(el);
            // costBlockApps.push(app);
        }
        
    }
    
}

export {initResponseVacancy};