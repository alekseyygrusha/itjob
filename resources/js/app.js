
// import Vue from 'vue'
import {selectors} from "./constants/app-selectors";
import {createApp} from "vue";
// window.Vue = require('vue').default
// import App from "./App";
import {ModalsContainer} from "vue-final-modal";

// const globalModalsApp = createApp({
//     name: 'GlobalModalsApp', 
//     components: {ModalsContainer}
// });
// globalModalsApp.mount("#global-modals-app");
const responseVacancy = () => import('./components/responseVacancy');
const responseResume = () => import('./components/responseResume');


// import modalsContainer from "./Modals/ModalsContainer.vue";


createApp({
    data() {
        return {
            counter: 0,
            modal_open: false
        }
    },
    components: {
        // modalsContainer,
        // responseVacancy
    }
}).mount("#app");


/** Динамические импорты **/ 
responseVacancy().then(({initResponseVacancy}) => {
    initResponseVacancy({})
});

responseResume().then(({initResponseResume}) => {
    initResponseResume({});
});


 /** Элементы на странице **/
// import {responseVacancy} from './components/responseVacancy';
// createApp(responseVacancy).mount('#app');

// if(response_vacancy.length) {
//     response_vacancy.forEach(element => {
//         new Vue({
//             element,
//             components: {
//                 responseVacancy
//             },
//         });
//     });
// }



