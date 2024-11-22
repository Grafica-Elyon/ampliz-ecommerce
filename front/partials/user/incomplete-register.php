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

                <!-- Campo de celular -->
                <div class="mp-form-group">
                    <label class="mp-label"><?= $data['label_celular'] ?></label>
                    <input class="mp-input" type="text" id="celular" name="celular"
                           value="<?= isset($this->data['fields']['celular']) ? $this->data['fields']['celular'] : '' ?>"
                           placeholder="<?= $data['placeholder_celular'] ?>" />
                    <small class="error-message" style="display: none; color: red;">Celular é obrigatório!</small>
                </div>

                <!-- Botão de submissão -->
                <div class="mp-form-footer">
                    <button type="submit" class="mp-btn-primary mp-link" id="submitBtn"><?= $data['botao'] ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Função para validar o formato do email
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Validação do formulário
    document.getElementById('mp-register').addEventListener('submit', function(event) {
        const emailField = document.getElementById('email');
        const celularField = document.getElementById('celular');
        const emailError = emailField.nextElementSibling;
        const celularError = celularField.nextElementSibling;

        let isValid = true;

        // **Log inicial do formulário**
        console.log("Validação do formulário iniciada.");
        console.log("Email:", emailField.value.trim());
        console.log("Celular:", celularField.value.trim());

        // Remove mensagens de erro anteriores
        [emailField, celularField].forEach(field => {
            field.classList.remove('error');
        });
        [emailError, celularError].forEach(error => {
            error.style.display = 'none';
        });

        // Validação do campo email
        if (!emailField.value.trim() || !validateEmail(emailField.value.trim())) {
            emailField.classList.add('error');
            emailError.style.display = 'block';
            console.log("Erro no campo Email: Valor inválido ou vazio.");
            isValid = false;
        } else {
            console.log("Campo Email validado com sucesso.");
        }

        // Validação do campo celular
        if (!celularField.value.trim()) {
            celularField.classList.add('error');
            celularError.style.display = 'block';
            console.log("Erro no campo Celular: Valor vazio.");
            isValid = false;
        } else {
            console.log("Campo Celular validado com sucesso.");
        }

        // Impede o envio do formulário se houver erros
        if (!isValid) {
            event.preventDefault();
            console.log("Formulário inválido. Submissão bloqueada.");
        } else {
            console.log("Formulário válido. Submissão permitida.");
        }

        // **Log final do estado dos campos**
        console.log("Estado final do campo Email:", emailField.value.trim(), emailField.classList.contains('error') ? "Com erro" : "Sem erro");
        console.log("Estado final do campo Celular:", celularField.value.trim(), celularField.classList.contains('error') ? "Com erro" : "Sem erro");
    });
</script>


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
