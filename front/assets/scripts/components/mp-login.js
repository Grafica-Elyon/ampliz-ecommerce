// Função para validar o formato do email
function validateEmail(email) {
    console.log("Validando email:", email); // Log para verificar o email recebido
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const isValid = regex.test(email);
    console.log("Email válido?", isValid); // Log para verificar se o email é válido
    return isValid;
}

// Função para capturar os campos de um formulário
function getInputs(form) {
    const values = {};
    form.querySelectorAll('input').forEach(input => {
        values[input.name] = input.value.trim();
    });
    console.log("Campos capturados do formulário:", values); // Log para verificar os valores capturados
    return values;
}

// Função para validação e envio do formulário
function validateAndSubmitForm(form) {
    console.log("Iniciando validação do formulário:", form); // Log para o formulário
    const emailField = form.querySelector('[name="email"]');
    const passwordField = form.querySelector('[name="password"], [name="func_senha"]');
    const celularField = form.querySelector('[name="celular"]');

    let isValid = true;

    // Remove erros visuais anteriores
    [emailField, passwordField, celularField].forEach(field => {
        if (field) field.classList.remove('error');
    });

    // Validação de email
    if (emailField) {
        console.log("Validando email:", emailField.value);
        if (!emailField.value.trim() || !validateEmail(emailField.value.trim())) {
            emailField.classList.add('error');
            alert('Por favor, insira um email válido.');
            emailField.focus();
            isValid = false;
        }
    }

    // Validação de senha
    if (passwordField) {
        console.log("Validando senha:", passwordField.value);
        if (!passwordField.value.trim()) {
            passwordField.classList.add('error');
            alert('O campo de senha não pode estar vazio.');
            passwordField.focus();
            isValid = false;
        }
    }

    // Validação de celular (para formulários que possuem esse campo)
    if (celularField) {
        console.log("Validando celular:", celularField.value);
        if (!celularField.value.trim()) {
            celularField.classList.add('error');
            alert('Por favor, insira um número de celular válido.');
            celularField.focus();
            isValid = false;
        }
    }

    // Submete o formulário se tudo estiver válido
    if (isValid) {
        console.log("Validação bem-sucedida. Submetendo o formulário.");
        form.submit();
    } else {
        console.log("Validação falhou. Formulário não será enviado."); // Log para falha na validação
    }
}

// Função principal para inicializar validações em todos os formulários
function initializeFormValidation() {
    console.log("Inicializando validação de formulários."); // Log de inicialização
    document.querySelectorAll('form').forEach(form => {
        console.log("Registrando evento para o formulário:", form); // Log do formulário
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            validateAndSubmitForm(form);
        });
    });
}

// Inicializa as validações quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', initializeFormValidation);
