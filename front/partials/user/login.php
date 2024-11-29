<?php
//comentado momentaneamente enquanto é resolvido o login social do facebook que está quebrando a tela.
//require_once('faceboockconfig.php');
//
//$redirectTo = "https://ampliz.com.br";
//$data = ['email'];
//$fullURL = $handler->getLoginUrl($redirectTo, $data);
?>

<?php
use MisterPrint\Support\View;
$data = $this->data['params'];
$is_balcony = $this->data['is_balcony']; ?>
<input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />

<div class="mp-login">
	<div class="mp-painel">
		<div class="mp-painel-header">
			<h3 class="mp-painel-title"><?= $data['titulo_login'] ?></h3>
		</div>

		<div class="mp-painel-body">
			<form method="POST" class="mp-login-form mp-form">
				<input type="hidden" name="action" value="mp_login" />
				<?php if(isset($this->data['redirect'])) { ?>
					<input type="hidden" name="redirect" value="<?php echo $this->data['redirect'] ?>" />
				<?php } ?>

				<?php wp_nonce_field( 'mp_login_action', 'mp_login' ); ?>

				<?php echo (new View('misc/errors', [
					'errors' => (isset($this->data['errors'])) ? $this->data['errors'] : []
				]))->get() ?>

				<div class="mp-form-group">
					<label class="mp-label"><?= $data['label_email_login'] ?></label>
					<input class="mp-input" type="text" name="email-login"
						   value="<?php echo isset($this->data['email_login']) ? $this->data['email_login'] : '' ?>"
						   placeholder="<?= $data['placeholder_email_login'] ?>" />
				</div>

				<div class="mp-form-group">
					<label class="mp-label"><?= $data['label_senha_login'] ?></label>
					<input class="mp-input" type="password" name="password-login" value="" placeholder="<?= $data['placeholder_senha_login'] ?>" />
				</div>

				<div class="mp-form-footer">
					<a class="mp-link mp-link-left" href="<?= \get_page_url('password_recovery') ?>"><?= $data['esqueceu_a_senha_login'] ?></a>
					<button type="submit" class="mp-btn-primary mp-link" ><?= $data['button_login'] ?></button>
				</div>
			</form>
		</div>

	</div>
</div>

<!-- Seção de login com redes sociais -->
 <!-- COMENTADO MOMENTANEAMENTE ENQUANTO É RESOLVIDO PROBLEMA QUE ESTÁ QUEBRANDO A TELA.
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center mt-3">
            <br>
            <span>Use sua rede social para se conectar*</span>
            <div class="GenericFooter">
                <input type="button" onclick="window.location = '<?php // echo $fullURL ?>'" value="Facebook" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>
				-->
<?php
//COMENTADO MOMENTANEAMENTE ENQUANTO É CORRIGIDO LOGIN SOCIAL.
//include_once(plugin_dir_path(__FILE__) . 'googlebutton.php');
?>

