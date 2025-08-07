$(document).ready(function(){
//funcao obter query pela url do navegador
function getQueryString(param) {
    var urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

})

