const bodyTablesEmployees = document.querySelector('#bodyTablesEmployees');

$('#listEmployees').DataTable({
    responsive: true,
}); 

const getEmployees = () => { 
    let accessToken = 'Bearer ' + sessionStorage.getItem('access_token').replace(/["']/g, "");

    fetch("http://127.0.0.1:8000/api/employees", {
        method: "GET",
        headers : {
            "Authorization" :  accessToken
        }
    }).then((response) => {
        return response.json();
    }).then((response) => {
        let listAllEmployees = response.data;
        console.log(listAllEmployees);
        let html = '';

        listAllEmployees.forEach(employee => {
            console.log(employee);
            const {first_name,last_name,document,phone,address,birthday,id} = employee;
            html += `<tr>
                <td>${id}</td>
                <td>${first_name}</td>
                <td>${last_name}</td>
                <td class="text-end">${document}</td>
                <td class="text-end">${phone}</td>
                <td>${address}</td>
                <td>${birthday}</td>
            </tr>`;
        });

        bodyTablesEmployees.innerHTML = html;
    })

}

getEmployees();