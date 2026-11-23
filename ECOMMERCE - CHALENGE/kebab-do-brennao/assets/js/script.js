// assets/js/script.js
document.addEventListener('DOMContentLoaded', function () {
    // Confirmação antes de ações destrutivas
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (ev) {
            if (!window.confirm(form.getAttribute('data-confirm'))) {
                ev.preventDefault();
            }
        });
    });

    // Validação de confirmação de senha no cadastro
    var senha = document.getElementById('senha');
    var confirmar = document.getElementById('confirmar');
    if (senha && confirmar) {
        var validar = function () {
            confirmar.setCustomValidity(senha.value !== confirmar.value ? 'As senhas não conferem.' : '');
        };
        senha.addEventListener('input', validar);
        confirmar.addEventListener('input', validar);
    }

    // Fecha mensagens flash automaticamente
    document.querySelectorAll('.flash-msg').forEach(function (el) {
        setTimeout(function () {
            if (window.bootstrap) { bootstrap.Alert.getOrCreateInstance(el).close(); }
        }, 6000);
    });
});
