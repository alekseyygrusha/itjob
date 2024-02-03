import {createApp} from "vue";
import adminPanel from "./adminPanel.vue";
import globalModalsPlugin from "@/globalModalsPlugin";
import {vfmPlugin} from 'vue-final-modal';
const initAdminPanel = () => {
    let elements = [...document.querySelectorAll('.admin-panel-vue')].filter(
        el => el.dataset.vApp === undefined
    );

    if (elements.length) {
        for (let el of elements) {
            createApp({
                name: 'adminPanelApp',
                components: {
                    adminPanel
                }
            })
                .use(vfmPlugin)
                .use(globalModalsPlugin)
                .mount(el);
        }

    }
}

export {initAdminPanel}
