import axios from "axios";

const ajax = {
    responseVacancy(data) {
        return axios({
            method: 'POST',
            data,
            url: '/ajax/vacancy-response',
        })
    },
    acceptResponseVacancy(data) {
        console.log('acceptResponseVacancy');
        return axios({
            method: 'POST',
            data,
            url: '/ajax/accept-vacancy-response',
        })
    },
    declineResponseVacancy(data) {
        return axios({
            method: 'POST',
            data,
            url: '/ajax/decline-vacancy-response',
        })
    },
    cancelResponseVacancy(data) {
        return axios({
            method: 'POST',
            data,
            url: '/ajax/cancel-vacancy-response',
        })
    },

    publicateVacancy(data) {
        return axios({
            method: 'POST',
            data,
            url: '/ajax/post-vacancy',
        })
    },

    publicateResume(data) {
        return axios({
            method: 'POST',
            data,
            url: '/ajax/resume/post',
        })
    },
    deleteResume(data) {
        return axios({
            method: 'POST',
            data,
            url: '/ajax/resume/delete',
        })
    },
    deleteVacancy(data) {
        return axios({
            method: 'POST',
            data,
            url: '/ajax/vacancy-delete',
        })
    },


    filterVacancies(data) {
        console.log('filter-vacancies');
        return axios({
            method: 'POST',
            data,
            url: '/ajax/filter-vacancies',
        })
    },

    getProject(data) {
        return axios({
            method: 'GET',
            params: data,
            url: '/ajax/project/get',
        })
    },

    saveProject(data) {
        return axios({
            method: 'POST',
            data,
            url: '/ajax/project/save',
        })
    },

    getProjectsList(data) {
        return axios({
            method: 'GET',
            params: data,
            url: '/ajax/project/get-list',
        })
    },

    deleteProjectResume(data) {
        return axios({
            method: 'POST',
            data,
            url: '/ajax/project/delete',
        })
    },
    getResume(data) {
        return axios({
            method: 'GET',
            params: data,
            url: '/ajax/resume/get-resume',
        })
    },

    getVacancyCandidates(data) {
        return axios({
            method: 'GET',
            params: data,
            url: '/ajax/vacancy/get-candidates',
        })
    },
    inviteCandidate(data) {
        return axios({
            method: 'POST',
            data,
            url: '/ajax/vacancy/invite-candidate',
        })
    },
    declineCandidate(data) {
        return axios({
            method: 'POST',
            data,
            url: '/ajax/vacancy/decline-candidate',
        })
    },

    getVacancyList(data) {
        return axios({
            method: 'GET',
            params: data,
            url: '/ajax/vacancy/get-list',
        })
    },

    setVacancyStatus(data) {
        return axios({
            method: 'POST',
            data,
            url: '/ajax/vacancy/set-vacancy-status',
        })
    },

    getVacancy(data) {
        return axios({
            method: 'GET',
            params: data,
            url: '/ajax/vacancy/get-card',
        })
    },
    getSkills(data) {
        return axios({
            method: 'GET',
            params: data,
            url: '/ajax/skills/get-list',
        })
    },
    addSkill(data) {
        return axios({
            method: 'POST',
            params: data,
            url: '/ajax/skills/add-skill',
        })
    }
};

export {ajax};
