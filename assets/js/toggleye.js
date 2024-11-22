    document.getElementById('toggle-eye').addEventListener('click', function() {
        var senhaInput = document.getElementById('senha');
        var eyeIcon = document.getElementById('eye-icon');

        if (senhaInput.type === 'password') {
            senhaInput.type = 'text'; // Mostra a senha
            eyeIcon.classList.remove('bi-eye-slash');
            eyeIcon.classList.add('bi-eye'); // Altera o ícone para "olho aberto"
        } else {
            senhaInput.type = 'password'; // Oculta a senha
            eyeIcon.classList.remove('bi-eye');
            eyeIcon.classList.add('bi-eye-slash'); // Altera o ícone para "olho fechado"
        }
    });
