const userName = document.querySelector('#userName');
const userEmail = document.querySelector('#userEmail');
const userSession = JSON.parse(sessionStorage.getItem('user'));

userName.innerHTML = `<b>Name</b> ${userSession.name}`;
userEmail.innerHTML = `<b>Email</b> ${userSession.email}`;
