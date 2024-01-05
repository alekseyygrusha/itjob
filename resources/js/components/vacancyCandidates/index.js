import {createApp} from "vue";
import vacancyCandidates from "./VacancyCandidates.vue";
import globalModalsPlugin from "@/globalModalsPlugin";
import {vfmPlugin} from 'vue-final-modal';

const initVacancyCandidates = () => {
    let elements = [...document.querySelectorAll('.vacancy-candidates-vue')].filter(
        el => el.dataset.vApp === undefined
    );

    if (elements.length) {
        for (let el of elements) {
            createApp({
                components: {
                    vacancyCandidates
                }
            })
                .use(vfmPlugin)
                .use(globalModalsPlugin)
                .mount(el);
        }

    }
}

export {initVacancyCandidates}
