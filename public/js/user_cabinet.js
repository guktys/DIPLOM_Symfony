document.getElementById('save-logo').addEventListener('click', function () {

    var fileInput = document.getElementById('formFile');
    var file = fileInput.files[0];

    var formData = new FormData();
    formData.append('file', file);

    fetch('/user_save_logo', {
        method: 'POST',
        body: formData
    })
        .then(data => {
            if (data.status === 'error') {

            } else {
                document.getElementById('alert-success').style.display = 'block';
                setTimeout(function () {
                    document.getElementById('changeLogoModal').classList.remove('show');
                    document.getElementById('changeLogoModal').style.display = 'none';
                    document.querySelector('.modal-backdrop').classList.remove('show');
                    document.querySelector('.modal-backdrop').style.display = 'none';
                }, 500);
                location.reload();
            }
        })
        .catch(error => {
            console.error('There was a problem with your fetch operation:', error);
        });
});


document.getElementById('save-pass').addEventListener('click', function () {
    var oldPass = document.getElementById('oldPass').value;
    var newPass = document.getElementById('newPass').value;
    var formData = new FormData();
    formData.append('oldPass', oldPass);
    formData.append('newPass', newPass);

    fetch('/new_user_pass', {
        method: 'POST',
        body: formData
    })
        .then(data => {
            if (data.status === 400) {
                document.getElementById('alert-pass-danger').style.display = 'block';
            } else if (data.status === 200) {
                document.getElementById('alert-pass-danger').style.display = 'none';
                document.getElementById('alert-pass-success').style.display = 'block';
                setTimeout(function () {
                    document.getElementById('changePassModal').classList.remove('show');
                    document.getElementById('changePassModal').style.display = 'none';
                    document.querySelector('.modal-backdrop').classList.remove('show');
                    document.querySelector('.modal-backdrop').style.display = 'none';
                }, 500);
                location.reload();
            }
        })
        .catch(error => {
            console.error('There was a problem with your fetch operation:', error);
        });
});