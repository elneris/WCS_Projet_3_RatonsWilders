function changeRole(userId)
{
    let url = '/admin/'+userId+'/changement-role';
    fetch(url)
        .then(response => response.json())
        .then(json => {
            let admin = document.getElementById('admin' + userId);
            if (json.isAdmin) {
                admin.classList.remove('far');
                admin.classList.remove('fa-times-circle');
                admin.classList.remove('text-danger');
                admin.classList.add('fas');
                admin.classList.add('fa-check-circle');
                admin.classList.add('text-success');
            } else {
                admin.classList.remove('fas');
                admin.classList.remove('fa-check-circle');
                admin.classList.remove('text-success');
                admin.classList.add('far');
                admin.classList.add('fa-times-circle');
                admin.classList.add('text-danger');
            }
        });
}

export default changeRole;