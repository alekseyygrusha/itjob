import {createApp} from "vue";
import vacancyFilter from "./vacancyFilter.vue";
const initVacancyFilter = () => {
    let elements = [...document.querySelectorAll('.vue-vacancy-filter')].filter(
        el => el.dataset.vApp === undefined
    );
    
    if (elements.length) {
        for (let el of elements) {
            createApp({
                name: 'vacancyFilterApp',
                components: {
                    vacancyFilter
                }
            }).mount(el);
        }
        
    }
    
}

export {initVacancyFilter};
