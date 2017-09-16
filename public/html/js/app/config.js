var env = 'local';
var isMobile = $.QueryString.mobile !== 'false'; //setting for web or mobile
var rootDeeplink = 'latifaspa://';
var baseUrl = 'http://latifa.dev';
var apiUrl = 'http://latifa.dev/api';

console.log($.QueryString.mobile);

var headers = {
    Accept:'application/json',
    Authorization:''
};

function setHeaders(headersBase64){

    headers = Base64.decode(headersBase64);
    headers = JSON.parse(headers);

}

if(!isMobile){

    headers.Authorization = 'bearer '+store.state.access_token;

}
