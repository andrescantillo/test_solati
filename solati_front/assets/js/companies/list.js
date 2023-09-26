const bodyTablesCompanies = document.querySelector('#bodyTablesCompanies');

$('#listCompanies').DataTable({
    responsive: true,
}); 

const getCompanies = () => { 
    let accessToken = 'Bearer ' + sessionStorage.getItem('access_token').replace(/["']/g, "");

    fetch("http://127.0.0.1:8000/api/companies", {
        method: "GET",
        headers : {
            "Authorization" :  accessToken
        }
    }).then((response) => {
        return response.json();
    }).then((response) => {
        let listAllCompanies = response.data;
        console.log(listAllCompanies);
        let html = '';

        listAllCompanies.forEach(company => {
            console.log(company);
            const {name,nit,phone, address,id} = company;
            html += `<tr>
                <td>${id}</td>
                <td>${name}</td>
                <td class="text-end">${nit}</td>
                <td class="text-end">${phone}</td>
                <td>${address}</td>
            </tr>`;
        });

        bodyTablesCompanies.innerHTML = html;
    })

}

getCompanies();