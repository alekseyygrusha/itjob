const ajax = {
    responseVacancy(data) {
        return axios({
            method: 'POST',
            data,
            url: 'ajax/vacancy-response',
        })
    },
    cancelResponseVacancy(data) {
        return axios({
            method: 'POST',
            data,
            url: 'ajax/cancel-vacancy-response',
        })
    }
};

export {ajax};