if(sessionStorage.getItem('user') == null || sessionStorage.getItem('access_token') == null){
    sessionStorage.clear();
    window.location.href = "index.html";
}