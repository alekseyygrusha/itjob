import {createApp} from "vue";
import selectOptions from "./selectOptions.vue";
const initSelectOptions = () => {
    let elements = [...document.querySelectorAll('.vue-select-options')].filter(
        el => el.dataset.vApp === undefined
    );
    console.log(elements);
    if (elements.length) {
        for (let el of elements) {
            createApp({
                name: 'selectOptionsApp',
                components: {
                    selectOptions
                }
            }).mount(el);
        }
        
    }
    
}

export {initSelectOptions};