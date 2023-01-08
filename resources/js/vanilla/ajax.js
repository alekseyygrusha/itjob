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
    }
};

export {ajax};