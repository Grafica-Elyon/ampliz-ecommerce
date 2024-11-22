<?php
use MisterPrint\Support\View;
$data = $this->data['params'];
?>

<div class="mp-login">
    <div class="mp-painel">
        <div class="mp-painel-header">
            <h3 class="mp-painel-title"><?= $data['titulo'] ?></h3>
        </div>

        <div class="mp-painel-body">
            <form method="POST" class="mp-login-form mp-form" id="mp-register">
                <input type="hidden" name="action" value="mp_incomplete_register"/>
                <input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />
                <?php if (isset($this->data['redirect'])) { ?>
                    <input type="hidden" name="redirect" value="<?php echo $this->data['redirect'] ?>"/>
                <?php } ?>

                <?php wp_nonce_field('mp_incomplete_register_action', 'mp_incomplete_register'); ?>

                <?php echo (new View('misc/errors', [
                    'errors' => (isset($this->data['errors'])) ? $this->data['errors'] : []
                ]))->get() ?>

                <!-- Campo de email -->
                <div class="mp-form-group">
                    <label class="mp-label"><?= $data['label_email'] ?></label>
                    <input class="mp-input" type="text" id="email" name="email"
                           value="<?= isset($this->data['fields']['email']) ? $this->data['fields']['email'] : '' ?>"
                           placeholder="<?= $data['placeholder_email'] ?>" />
                    <small class="error-message" style="display: none; color: red;">E-mail é obrigatório e deve ser válido!</small>
                </div>

                <!-- Campo de confirmação de email -->
                <div class="mp-form-group">
                    <label class="mp-label"><?= $data['label_confirm_email'] ?></label>
                    <input class="mp-input" type="text" id="confirm-email" name="confirm-email"
                           placeholder="<?= $data['placeholder_confirm_email'] ?>" />
                    <small class="error-message" style="display: none; color: red;">A confirmação de e-mail deve ser igual ao e-mail!</small>
                </div>

                <!-- Campo de nome completo -->
                <div class="mp-form-group">
                    <label class="mp-label"><?= $data['label_nome_completo'] ?></label>
                    <input class="mp-input" type="text" id="nome-completo" name="nome-completo"
                           placeholder="<?= $data['placeholder_nome_completo'] ?>" />
                    <small class="error-message" style="display: none; color: red;">O nome é obrigatório!</small>
                </div>

                <!-- Botão de submissão -->
                <div class="mp-form-footer">
                    <button type="submit" class="mp-btn-primary mp-link" id="submitBtn"><?= $data['botao'] ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/scripts/components/mp-incomplete-register.js"></script>

<style>
    /* Estilo para campos com erro */
    .error {
        border: 2px solid red;
    }

    .mp-painel {
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    .mp-painel-header {
        margin-bottom: 15px;
    }

    .mp-btn-primary {
        background-color: #0073aa;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .mp-btn-primary:hover {
        background-color: #005885;
    }
</style>
