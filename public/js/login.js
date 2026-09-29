const loginForm = document.getElementById('login-form');
const loginError = document.getElementById('form-error');

loginForm.addEventListener('submit', function (event) {
    event.preventDefault();
    loginError.hidden = true;

    fetch(API_URL + '?action=login', {
        method: 'POST',
        body: new FormData(loginForm)
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (data.error) {
                loginError.textContent = data.error;
                loginError.hidden = false;
                return;
            }
            window.location.href = 'account.html';
        })
        .catch(function () {
            loginError.textContent = 'A apărut o eroare. Încercați din nou.';
            loginError.hidden = false;
        });
});
