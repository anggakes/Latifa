// Add a response interceptor
axios.interceptors.response.use(function (response) {
    // Do something with response data
    return response;
}, function (error) {
    if (401 === error.response.status) {
        if(!isMobile){
            axios({
                method: 'post',
                data : {
                    email : 'anggakesuma123@gmail.com',
                    password : '12345678'
                },
                url: apiUrl+'/customer/login',
                headers: {Accept:'application/json'}
            }).then(function (response) {

                console.log(response.data.data);
                store.commit('setLogin', response.data.data);
                location.reload();
            });
        }else{
            window.location = rootDeeplink+'login?redirect='+rootDeeplink+'cart';
        }
    }

    return Promise.reject(error.response);
});