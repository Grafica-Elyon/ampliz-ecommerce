<?php
// header.php, login.php, facebookconfig.php

// Caminho para o arquivo de log
$logFile = __DIR__ . '/log_api_facebook.log';

// Mensagem a ser gravada
$logMessage = "[" . date('Y-m-d H:i:s') . "] Sua mensagem aqui." . PHP_EOL;

// Grava a mensagem no arquivo de log
file_put_contents($logFile, $logMessage, FILE_APPEND);

// Inclui o arquivo de configuração do Facebook
require_once('faceboockconfig.php');
$redirectTo = "https://dev.ampliz.com.br"; // URL para onde o usuário será redirecionado após o login
$data = ['email']; // Permissões solicitadas ao Facebook (neste caso, apenas email)
$fullURL = $handler->getLoginUrl($redirectTo, $data); // Gera a URL de login do Facebook

use MisterPrint\Support\View;
use MisterPrint\Helper\Log;

$data = $this->data['params'];
$is_balcony = $this->data['is_balcony'];

// Validação dos dados do formulário
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $func_email = $_POST['func_email'] ?? '';
    $func_password = $_POST['func_senha'] ?? '';

    // Validação de e-mail
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "O campo E-mail é obrigatório e deve ser válido.";
    }

    // Validação de senha
    if (empty($password)) {
        $errors['password'] = "O campo Senha é obrigatório.";
    }

    // Validação de funcionário (apenas se for balcão)
    if ($is_balcony) {
        if (empty($func_email) || !filter_var($func_email, FILTER_VALIDATE_EMAIL)) {
            $errors['func_email'] = "O campo E-mail do funcionário é obrigatório e deve ser válido.";
        }
        if (empty($func_password)) {
            $errors['func_password'] = "O campo Senha do funcionário é obrigatório.";
        }
    }

    // Se não houver erros, processe os dados
    if (empty($errors)) {
        // Aqui você pode processar os dados, como enviar para o backend ou redirecionar
        header("Location: success_page.php");
        exit();
    }
}
?>

<!-- Renderização do formulário com erros -->
<input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />

<div class="mp-login">
    <div class="mp-painel">
        <div class="mp-painel-header">
            <h3 class="mp-painel-title"><?= $data['titulo'] ?></h3>
        </div>

        <?php if ($is_balcony): ?>
            <div class="mp-painel-body">
                <form method="POST" class="mp-login-form mp-form">
                    <?php wp_nonce_field('mp_login_action', 'mp_login'); ?>

                    <!-- Erro de E-mail -->
                    <?php if (!empty($errors['func_email'])): ?>
                        <div class="error-message" style="color: red;"><?= $errors['func_email'] ?></div>
                    <?php endif; ?>
                    <div class="mp-form-group">
                        <label class="mp-label"><?= $data['funcionario_label_email'] ?></label>
                        <input class="mp-input" type="text" name="func_email"
                               value="<?= htmlspecialchars($_POST['func_email'] ?? '') ?>"
                               placeholder="<?= $data['funcionario_placeholder_email'] ?>" />
                    </div>

                    <!-- Erro de Senha -->
                    <?php if (!empty($errors['func_password'])): ?>
                        <div class="error-message" style="color: red;"><?= $errors['func_password'] ?></div>
                    <?php endif; ?>
                    <div class="mp-form-group">
                        <label class="mp-label"><?= $data['funcionario_label_senha'] ?></label>
                        <input class="mp-input" type="password" name="func_senha"
                               value="<?= htmlspecialchars($_POST['func_senha'] ?? '') ?>"
                               placeholder="<?= $data['funcionario_placeholder_senha'] ?>" />
                    </div>

                    <div class="mp-form-footer">
                        <button type="submit" class="mp-btn-primary mp-link"><?= $data['botao'] ?></button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="mp-painel-body">
                <form method="POST" class="mp-login-form mp-form">
                    <?php wp_nonce_field('mp_login_action', 'mp_login'); ?>

                    <!-- Erro de E-mail -->
                    <?php if (!empty($errors['email'])): ?>
                        <div class="error-message" style="color: red;"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                    <div class="mp-form-group">
                        <label class="mp-label"><?= $data['label_email'] ?></label>
                        <input class="mp-input" type="text" name="email"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                               placeholder="<?= $data['placeholder_email'] ?>" />
                    </div>

                    <!-- Erro de Senha -->
                    <?php if (!empty($errors['password'])): ?>
                        <div class="error-message" style="color: red;"><?= $errors['password'] ?></div>
                    <?php endif; ?>
                    <div class="mp-form-group">
                        <label class="mp-label"><?= $data['label_senha'] ?></label>
                        <input class="mp-input" type="password" name="password"
                               value="<?= htmlspecialchars($_POST['password'] ?? '') ?>"
                               placeholder="<?= $data['placeholder_senha'] ?>" />
                    </div>

                    <div class="mp-form-footer">
                        <button type="submit" class="mp-btn-primary mp-link"><?= $data['botao'] ?></button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>
