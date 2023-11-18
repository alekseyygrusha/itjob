
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
const postVacancy = () => import('./components/postVacancy');
const postResume = () => import('./components/postResume');
const selectOptions = () => import('./components/selectOptions');
const vacancyFilter = () => import('./components/vacancyFilter');


/** Динамические импорты **/
responseVacancy().then(({initResponseVacancy}) => {
    initResponseVacancy({})
});

vacancyFilter().then(({initVacancyFilter}) => {
    initVacancyFilter({})
});


responseResume().then(({initResponseResume}) => {
    initResponseResume({});
});

postVacancy().then(({initPostVacancy}) => {
    initPostVacancy({});
});

postResume().then(({initPostResume}) => {
    initPostResume({});
});

selectOptions().then(({initSelectOptions}) => {
    initSelectOptions({});
});
