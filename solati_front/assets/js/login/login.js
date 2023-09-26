const frmLogin = document.querySelector("#formLogin");

frmLogin.addEventListener("submit", (e) => {
  e.preventDefault();
  const formData = new FormData(frmLogin);

  const nick = formData.get("nick").trim();
  const password = formData.get("password").trim();

    if(nick == '' || password == '') {
        return Swal.fire({
            text: "User and password must be required",
            icon: "warning",
            confirmButtonText: "Ok",
        });
    }

  fetch("http://127.0.0.1:8000/api/auth/login", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      return response.json();
    })
    .then((response) => {
      if (response.code == 401) {
        return Swal.fire({
          text: response.errors,
          title: response.message,
          icon: "error",
          confirmButtonText: "Close",
        });
      }

      if (response.status == "Error") {

        let html = `<ul class="list-group">`;

        for (const clave in response.errors) {
          if (response.errors.hasOwnProperty(clave)) {

            const errorMessage = response.errors[clave];

            errorMessage.forEach((error) => {
              html += `<li class="list-group-item">${error}</li>`;
            });

          }
        }

        html += `</ul>`;

        return Swal.fire({
          html: html,
          icon: "error",
          confirmButtonText: "Close",
        });
      }

      if(response.code == 200) {
        sessionStorage.setItem('user',JSON.stringify(response.data.user));
        sessionStorage.setItem('access_token',JSON.stringify(response.data.access_token));

        window.location.href = "main.html";
      }
    })
    .catch((error) => {
      return Swal.fire({
        text: "Something went wrong with the server",
        title: "Server Error",
        icon: "error",
        confirmButtonText: "Close",
      });
    });
});
