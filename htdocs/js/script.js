document.addEventListener('DOMContentLoaded', function() {
    // Walidacja formularza logowania
    var loginForm = document.querySelector('form[action="index.php"]');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            var username = document.getElementById('username').value.trim();
            var password = document.getElementById('password').value.trim();

            if (!username || !password) {
                e.preventDefault();
                alert("Proszę wypełnić wszystkie pola.");
            }
        });
    }

    // Walidacja formularza wiadomości
    var messageForm = document.querySelector('.send-message form');
    if (messageForm) {
        messageForm.addEventListener('submit', function(e) {
            var message = document.getElementById('message').value.trim();
            if (!message) {
                e.preventDefault();
                alert("Proszę wpisać wiadomość.");
            }
        });
    }

    // Czysczenie wiadmości na ekranie
    document.getElementById('clear-messages').addEventListener('click', function () {
        var messagesDiv = document.querySelector('.messages');
        while (messagesDiv.firstChild) {
            messagesDiv.removeChild(messagesDiv.firstChild);
        }
    });

    // Zwijanie/rozwijanie wiadomości
    document.querySelectorAll('.toggle-message').forEach(function(button) {
        button.addEventListener('click', function() {
            var msgId = this.getAttribute('data-id');
            var messageDiv = document.getElementById(msgId);
            if (messageDiv) {
                var messageContent = messageDiv.querySelector('p');
                var smallContent = messageDiv.querySelector('small');

                if (messageContent && smallContent) {
                    if (messageContent.style.display === 'none' || messageContent.style.display === '') {
                        messageContent.style.display = 'block';
                        smallContent.style.display = 'block';
                        this.textContent = 'Zwiń';
                    } else {
                        messageContent.style.display = 'none';
                        smallContent.style.display = 'none';
                        this.textContent = 'Rozwiń';
                    }
                }
            }
        });
    });
});