document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        const input = document.getElementById(button.getAttribute('aria-controls'));

        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        button.addEventListener('click', () => {
            const showPassword = input.type === 'password';
            input.type = showPassword ? 'text' : 'password';
            button.setAttribute('aria-pressed', String(showPassword));
            button.textContent = showPassword ? 'Ocultar' : 'Mostrar';
        });
    });

    const feedback = document.querySelector('[data-form-feedback]');
    if (!(feedback instanceof HTMLElement)) {
        return;
    }

    const params = new URLSearchParams(window.location.search);
    const error = params.get('erro');
    const registration = params.get('cadastro');
    const messages = {
        credentials: 'Não foi possível entrar. Confira o e-mail e a senha e tente novamente.',
        invalid: 'Revise os dados informados e tente novamente.',
        duplicate: 'Já existe uma conta cadastrada com esse e-mail.',
        registered: 'Cadastro realizado. Agora você já pode entrar.',
    };
    const message = error === 'credenciais'
        ? messages.credentials
        : registration === 'duplicado'
            ? messages.duplicate
            : registration === 'sucesso'
                ? messages.registered
                : error === 'dados'
                    ? messages.invalid
                    : null;

    if (message) {
        feedback.textContent = message;
        feedback.hidden = false;
        feedback.setAttribute('role', registration === 'sucesso' ? 'status' : 'alert');
    }
});
