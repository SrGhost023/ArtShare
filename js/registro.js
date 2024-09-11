document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.register-form');
    const popup = document.getElementById('popup-message');
    const popupText = document.getElementById('popup-message-text');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); 

        const formData = new FormData(form);

        fetch('../php/procesar_registro.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.href = '../pages/login.html';
            } else {
                popupText.textContent = data.message;
                popup.classList.add('show');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    function closePopup() {
        popup.classList.remove('show');
    }

    window.closePopup = closePopup;
});
