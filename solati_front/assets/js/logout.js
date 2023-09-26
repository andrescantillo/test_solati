const LogOut = document.querySelector("#logout");
let accessToken = 'Bearer ' + sessionStorage.getItem('access_token').replace(/["']/g, "");

LogOut.addEventListener("click", () => {
  fetch("http://127.0.0.1:8000/api/auth/logout", {
    method: "POST",
    headers : {
        "Authorization" :  accessToken
    }
  }).then((response) => {
    return response.json();
  }).then((response) => {
    if(response.code == 200 || response.code == 422){
        sessionStorage.clear();
        window.location.href = "index.html";
    }
  }).catch((error) => {
        sessionStorage.clear();
        window.location.href = "index.html";
  });
  
});
