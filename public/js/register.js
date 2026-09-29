const registerForm = document.getElementById('register-form');
const registerError = document.getElementById('form-error');

registerForm.addEventListener('submit', function (event) {
    event.preventDefault();
    registerError.hidden = true;

    if (registerForm.password.value !== registerForm.password_confirm.value) {
        registerError.textContent = 'Parolele nu coincid.';
        registerError.hidden = false;
        return;
    }

    fetch(API_URL + '?action=register', {
        method: 'POST',
        body: new FormData(registerForm)
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (data.error) {
                registerError.textContent = data.error;
                registerError.hidden = false;
                return;
            }
            window.location.href = 'account.html';
        })
        .catch(function () {
            registerError.textContent = 'A apărut o eroare. Încercați din nou.';
            registerError.hidden = false;
        });
});
