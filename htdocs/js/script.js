// Walidacja formularza logowania
document.querySelector('form[action="index.php"]').addEventListener('submit', function (e) {
    var username = document.getElementById('username').value.trim();
    var password = document.getElementById('password').value.trim();

    if (!username || !password) {
        e.preventDefault();
        alert("Proszę wypełnić wszystkie pola.");
    }
});

// Walidacja formularza wiadomości
document.querySelector('.send-message form').addEventListener('submit', function (e) {
    var message = document.getElementById('message').value.trim();
    if (!message) {
        e.preventDefault();
        alert("Proszę wpisać wiadomość.");
    }
});