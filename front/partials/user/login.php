<?php
// header.php, login.php, facebookconfig.php

// Caminho para o arquivo de log
$logFile = __DIR__ . '/log_api_facebook.log';

// Mensagem a ser gravada
$logMessage = "[" . date('Y-m-d H:i:s') . "] Sua mensagem aqui." . PHP_EOL;

// Grava a mensagem no arquivo de log
file_put_contents($logFile, $logMessage, FILE_APPEND);

?>

<?php
require_once('faceboockconfig.php'); // Inclui o arquivo de configuração do Facebook
$redirectTo = "https://dev.ampliz.com.br"; // URL para onde o usuário será redirecionado após o login
$data = ['email']; // Permissões solicitadas ao Facebook (neste caso, apenas email)
$fullURL = $handler->getLoginUrl($redirectTo, $data); // Gera a URL de login do Facebook

use MisterPrint\Support\View;
use MisterPrint\Helper\Log;
$data = $this->data['params'];
$is_balcony = $this->data['is_balcony']; ?>

<input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />

<div class="mp-login">
    <div class="mp-painel">
        <div class="mp-painel-header">
            <h3 class="mp-painel-title"><?= $data['titulo'] ?></h3>
        </div>

        <?php if ($is_balcony): ?>
            <div class="mp-painel-body">
                <form method="POST" class="mp-login-form mp-form">
                    <input type="hidden" name="action" value="mp_login_funcionario" />
                    <input type="hidden" name="from-session" value="<?= json_encode(!!$this->data['funcionario-session']) ?>" />
                    <?php if(isset($this->data['redirect'])) { ?>
                        <input type="hidden" name="redirect" value="<?php echo $this->data['redirect'] ?>" />
                    <?php } ?>

                    <?php wp_nonce_field('mp_login_action', 'mp_login'); ?>

                    <?php echo (new View('misc/errors', [
                        'errors' => (isset($this->data['errors'])) ? $this->data['errors'] : []
                    ]))->get() ?>
                    <div class="mp-form-group">
                        <label class="mp-label"><?= $data['funcionario_label_email'] ?></label>
                        <input class="mp-input" type="text" id="func_email" name="func_email"
                               value="<?php echo isset($this->data['email']) ? $this->data['email'] : '' ?>"
                               placeholder="<?= $data['funcionario_placeholder_email'] ?>" />
                    </div>

                    <div class="mp-form-group">
                        <label class="mp-label"><?= $data['funcionario_label_senha'] ?></label>
                        <input class="mp-input" type="password" id="func_password" name="func_senha"
                               placeholder="<?= $data['funcionario_placeholder_senha'] ?>" />
                    </div>

                    <div class="mp-form-group">
                        <label class="mp-label"><?= $data['funcionario_login_cliente'] ?></label>
                        <input class="mp-input" type="text" id="email" name="email"
                               autocomplete="off"
                               value="<?php echo isset($this->data['email']) ? $this->data['email'] : '' ?>"
                               placeholder="<?= $data['placeholder_email'] ?>" />
                    </div>

                    <div class="mp-form-footer">
                        <button type="button" id="loginBtn" class="mp-btn-primary mp-link"><?= $data['botao'] ?></button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="mp-painel-body">
                <form method="POST" class="mp-login-form mp-form">
                    <input type="hidden" name="action" value="mp_login" />
                    <?php if (isset($this->data['redirect'])) { ?>
                        <input type="hidden" name="redirect" value="<?php echo $this->data['redirect'] ?>" />
                    <?php } ?>

                    <?php wp_nonce_field('mp_login_action', 'mp_login'); ?>

                    <?php echo (new View('misc/errors', [
                        'errors' => (isset($this->data['errors'])) ? $this->data['errors'] : []
                    ]))->get(); ?>

                    <div class="mp-form-group">
                        <label class="mp-label"><?= $data['label_email'] ?></label>
                        <input class="mp-input" type="text" id="email" name="email"
                               value="<?php echo isset($this->data['email']) ? $this->data['email'] : '' ?>"
                               placeholder="<?= $data['placeholder_email'] ?>" />
                    </div>

                    <div class="mp-form-group">
                        <label class="mp-label"><?= $data['label_senha'] ?></label>
                        <input class="mp-input" type="password" id="password" name="password"
                               placeholder="<?= $data['placeholder_senha'] ?>" />
                    </div>

                    <div class="mp-form-footer">
                        <a class="mp-link mp-link-left" href="<?= \get_page_url('password_recovery') ?>"><?= $data['esqueceu_a_senha'] ?></a>
                        <button type="button" id="loginBtn" class="mp-btn-primary mp-link"><?= $data['botao'] ?></button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Seção de login com redes sociais -->
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center mt-3">
            <br>
            <span>Use sua rede social para se conectar*</span>
            <div class="GenericFooter">
                <input type="button" onclick="window.location = '<?php echo $fullURL ?>'" value="Facebook" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>
<?php
include_once(plugin_dir_path(__FILE__) . 'googlebutton.php');
?>

<script>
// Função para validar o formato do email
function validateEmail(email) {
    console.log("Validando email:", email); // Log para verificar o email recebido
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const isValid = regex.test(email);
    console.log("Email válido?", isValid); // Log para verificar se o email é válido
    return isValid;
}

// Adicionando evento de clique ao botão de login
document.querySelectorAll('#loginBtn').forEach(button => {
    console.log("Adicionando evento ao botão de login."); // Log ao adicionar o evento ao botão
    button.addEventListener('click', function (event) {
        event.preventDefault();
        console.log("Botão de login clicado."); // Log quando o botão é clicado

        // Identifica o formulário correspondente
        const form = this.closest('form');
        console.log("Formulário identificado:", form); // Log para garantir que o formulário foi identificado

        // Captura os campos do formulário
        const emailField = form.querySelector('[name="email"]');
        const passwordField = form.querySelector('[name="password"], [name="func_senha"]');
        const funcEmailField = form.querySelector('[name="func_email"]');

        console.log("Campo de email encontrado?", emailField !== null);
        console.log("Campo de senha encontrado?", passwordField !== null);
        console.log("Campo de email do funcionário encontrado?", funcEmailField !== null);

        let isValid = true;

        // Remove erros anteriores
        [emailField, passwordField, funcEmailField].forEach(field => {
            if (field) {
                field.classList.remove('error');
                console.log("Removendo erros do campo:", field.name); // Log ao remover erros
            }
        });

        // Valida o email principal
        if (emailField) {
            console.log("Validando email principal:", emailField.value);
            if (!emailField.value.trim()) {
                console.log("Erro: Campo de email está vazio."); // Log para campo vazio
                emailField.classList.add('error');
                alert('Por favor, insira um email válido.');
                emailField.focus();
                isValid = false;
            } else if (!validateEmail(emailField.value.trim())) {
                console.log("Erro: Email inválido."); // Log para email inválido
                emailField.classList.add('error');
                alert('Por favor, insira um email válido.');
                emailField.focus();
                isValid = false;
            }
        }

        // Valida o email do funcionário (se aplicável)
        if (funcEmailField) {
            console.log("Validando email do funcionário:", funcEmailField.value);
            if (!funcEmailField.value.trim()) {
                console.log("Erro: Campo de email do funcionário está vazio."); // Log para campo vazio
                funcEmailField.classList.add('error');
                alert('Por favor, insira um email válido para o funcionário.');
                funcEmailField.focus();
                isValid = false;
            } else if (!validateEmail(funcEmailField.value.trim())) {
                console.log("Erro: Email do funcionário inválido."); // Log para email inválido
                funcEmailField.classList.add('error');
                alert('Por favor, insira um email válido para o funcionário.');
                funcEmailField.focus();
                isValid = false;
            }
        }

        // Valida o campo de senha
        if (passwordField) {
            console.log("Validando senha:", passwordField.value);
            if (!passwordField.value.trim()) {
                console.log("Erro: Campo de senha está vazio."); // Log para senha vazia
                passwordField.classList.add('error');
                alert('O campo de senha não pode estar vazio.');
                passwordField.focus();
                isValid = false;
            }
        }

        // Se tudo estiver válido, submete o formulário
        if (isValid) {
            console.log("Validação concluída com sucesso. Formulário será enviado.");
            form.submit();
        } else {
            console.log("Validação falhou. Formulário não será enviado."); // Log para falha na validação
        }
    });
});

// Log inicial para verificar se o script foi carregado
console.log("Script de validação carregado com sucesso.");

</script>

<style>
/* Estilo para campos com erro */
.error {
    border: 2px solid red;
}
</style>
