import {createApp} from "vue";
import postResume from "./postResume.vue";

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
            }).mount(el);
        }

    }
}

export {initPostResume}
