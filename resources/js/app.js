
// import Vue from 'vue'
import {selectors} from "./constants/app-selectors";
import {createApp} from "vue";
// window.Vue = require('vue').default
// import App from "./App";



const responseVacancy = () => import('./components/responseVacancy');
const responseResume = () => import('./components/responseResume');
const postVacancy = () => import('./components/postVacancy');
const postResume = () => import('./components/postResume');
const selectOptions = () => import('./components/selectOptions');
const vacancyFilter = () => import('./components/vacancyFilter');
const vacancyCandidates = () => import('./components/vacancyCandidates');
const adminPanel = () => import('./components/adminPanel');


/** Динамические импорты **/
vacancyCandidates().then(({initVacancyCandidates}) => {
    initVacancyCandidates({})
});
/*adminPanel().then(({initAdminPanel}) => {
    initAdminPanel({})
});*/

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
