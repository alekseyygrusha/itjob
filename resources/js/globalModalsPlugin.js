import {createApp} from "vue";
import {ModalsContainer} from "vue-final-modal";
import {vfmPlugin} from 'vue-final-modal';

const globalModalsApp = createApp({
    name: 'GlobalModalsApp',
    components: {ModalsContainer}
});
globalModalsApp.use(vfmPlugin);
globalModalsApp.mount("#global-modals-app");

export default {
    install: (app, options) => {
        app.config.globalProperties.$modal = globalModalsApp.config.globalProperties.$vfm;
    }
}
