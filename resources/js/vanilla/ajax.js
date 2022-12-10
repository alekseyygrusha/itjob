const ajax = {
    responseVacancy(data) {
        return axios({
            method: 'POST',
            data,
            url: 'ajax/vacancy-response',
        })
    },
};

export {ajax};