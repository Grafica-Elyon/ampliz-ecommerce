<?php
// Caminho para o arquivo de log
$logFile = __DIR__ . '/log_api_facebook.log';
$logMessage = "[" . date('Y-m-d H:i:s') . "] Login iniciado." . PHP_EOL;
file_put_contents($logFile, $logMessage, FILE_APPEND);

// Configuração do Facebook
require_once('faceboockconfig.php');
$redirectTo = "https://dev.ampliz.com.br";
$data = ['email'];
$fullURL = $handler->getLoginUrl($redirectTo, $data);

// Validação no servidor
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['email'])) {
        $errors['email'] = 'O e-mail é obrigatório.';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'O e-mail informado é inválido.';
    }
    if (empty($_POST['password'])) {
        $errors['password'] = 'A senha é obrigatória.';
    }

    // Retorna erros ou continua o fluxo
    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'errors' => $errors]);
        exit;
    } else {
        // Sucesso: redirecionar ou realizar outra ação
        echo json_encode(['status' => 'success', 'redirect' => '/dashboard']);
        exit;
    }
}

// Dados de configuração
use MisterPrint\Support\View;
$data = $this->data['params'];
$is_balcony = $this->data['is_balcony'];
?>

<!-- Adiciona o parâmetro codificado -->
<input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />

<div class="mp-login">
    <div class="mp-painel">
        <div class="mp-painel-header">
            <h3 class="mp-painel-title"><?= $data['titulo'] ?></h3>
        </div>
        <div class="mp-painel-body">
            <form method="POST" id="login-form" class="mp-login-form mp-form">
                <input type="hidden" name="action" value="<?= $is_balcony ? 'mp_login_funcionario' : 'mp_login' ?>" />
                <?php wp_nonce_field('mp_login_action', 'mp_login'); ?>

                <!-- Mensagens de erro do servidor -->
                <?php if (!empty($errors)): ?>
                    <div class="error-container">
                        <?php foreach ($errors as $field => $message): ?>
                            <p class="error-message"><strong><?= ucfirst($field) ?>:</strong> <?= $message ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Campo de e-mail -->
                <div class="mp-form-group">
                    <label class="mp-label">E-mail</label>
                    <input class="mp-input" type="text" name="email" value="" placeholder="Digite seu e-mail" />
                </div>

                <!-- Campo de senha -->
                <div class="mp-form-group">
                    <label class="mp-label">Senha</label>
                    <input class="mp-input" type="password" name="password" placeholder="Digite sua senha" />
                </div>

                <!-- Botão de submissão -->
                <div class="mp-form-footer">
                    <button type="submit" class="mp-btn-primary mp-link"><?= $data['botao'] ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Seção de login com redes sociais -->
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center mt-3">
            <span>Use sua rede social para se conectar*</span>
            <div class="GenericFooter">
                <input type="button" onclick="window.location = '<?= $fullURL ?>'" value="Facebook" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>

<!-- Inclusão do script Google -->
<?php include_once(plugin_dir_path(__FILE__) . 'googlebutton.php'); ?>


<style>
/* Estilo para campos com erro */
.error-message {
    color: red;
    font-size: 0.9rem;
    margin-top: 5px;
}

.mp-input.error {
    border: 2px solid red;
}

/* Estilo do painel */
.mp-painel {
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 20px;
    background: #f9f9f9;
}

.mp-painel-header h3 {
    margin: 0;
    font-size: 1.5rem;
}

.mp-btn-primary {
    background-color: #0073aa;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.mp-btn-primary:hover {
    background-color: #005885;
}

.GenericFooter .btn-primary {
    margin-top: 10px;
}
</style>
