<?php
require_once('faceboockconfig.php');

$redirectTo = "https://ampliz.com.br";
$data = ['email'];
$fullURL = $handler->getLoginUrl($redirectTo, $data);

?>


<?php
use MisterPrint\Support\View;
$data = $this->data['params'];
$is_balcony = $this->data['is_balcony']; ?>
<input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />

<div class="mp-login">
	<div class="mp-painel">
		<div class="mp-painel-header">
			<h3 class="mp-painel-title"><?= $data['titulo'] ?></h3>
		</div>

		<?php if ( $is_balcony ): ?>
			<div class="mp-painel-body">
				<form method="POST" class="mp-login-form mp-form">
					<input type="hidden" name="action" value="mp_login_funcionario" />
					<input type="hidden" name="from-session" value="<?= json_encode(!!$this->data['funcionario-session']) ?>" />
					<?php if(isset($this->data['redirect'])) { ?>
						<input type="hidden" name="redirect" value="<?php echo $this->data['redirect'] ?>" />
					<?php } ?>

					<?php wp_nonce_field( 'mp_login_action', 'mp_login' ); ?>

					<?php echo (new View('misc/errors', [
						'errors' => (isset($this->data['errors'])) ? $this->data['errors'] : []
					]))->get() ?>
						<div class="mp-form-group">
							<label class="mp-label"><?= $data['funcionario_label_email'] ?></label>
							<input class="mp-input" type="text" name="func_email"
								   value="<?php echo isset($this->data['email']) ? $this->data['email'] : '' ?>"
								   placeholder="<?= $data['funcionario_placeholder_email'] ?>" />
						</div>

						<div class="mp-form-group">
							<label class="mp-label"><?= $data['funcionario_label_senha'] ?></label>
							<input class="mp-input" type="password" name="func_senha" value="" placeholder="<?= $data['funcionario_placeholder_senha'] ?>" />
						</div>

					<div class="mp-form-group">
						<label class="mp-label"><?= $data['funcionario_login_cliente'] ?></label>
						<input class="mp-input" type="text" name="email"
							   autocomplete="off"
							   value="<?php echo isset($this->data['email']) ? $this->data['email'] : '' ?>"
							   placeholder="<?= $data['placeholder_email'] ?>" />
					</div>

					<div class="mp-form-footer">
						<button type="submit" class="mp-btn-primary mp-link" ><?= $data['botao'] ?></button>
					</div>
				</form>
			</div>
		<?php else: ?>

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
					<label class="mp-label"><?= $data['label_email'] ?></label>
					<input class="mp-input" type="text" name="email"
						   value="<?php echo isset($this->data['email']) ? $this->data['email'] : '' ?>"
						   placeholder="<?= $data['placeholder_email'] ?>" />
				</div>

				<div class="mp-form-group">
					<label class="mp-label"><?= $data['label_senha'] ?></label>
					<input class="mp-input" type="password" name="password" value="" placeholder="<?= $data['placeholder_senha'] ?>" />
				</div>

				<div class="mp-form-footer">
					<a class="mp-link mp-link-left" href="<?= \get_page_url('password_recovery') ?>"><?= $data['esqueceu_a_senha'] ?></a>
					<button type="submit" class="mp-btn-primary mp-link" ><?= $data['botao'] ?></button>
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

