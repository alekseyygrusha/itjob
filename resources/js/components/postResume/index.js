import {createApp} from "vue";
import postResume from "./postResume.vue";
import globalModalsPlugin from "@/globalModalsPlugin";
import {vfmPlugin} from 'vue-final-modal';
const initPostResume = () => {
    console.log("initPostResume");
    let elements = [...document.querySelectorAll('.post-resume-form')].filter(
        el => el.dataset.vApp === undefined
    );

    if (elements.length) {
        for (let el of elements) {
            createApp({
                components: {
                    postResume
                }
            })
                .use(vfmPlugin)
                .use(globalModalsPlugin)
                .mount(el);
        }

    }
}

export {initPostResume}
