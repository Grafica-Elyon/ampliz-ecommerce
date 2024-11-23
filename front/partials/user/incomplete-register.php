<?php
use MisterPrint\Support\View;
$data = $this->data['params'];
?>
<div class="mp-login">
	<div class="mp-painel">
		<div class="mp-painel-header">
			<h3 class="mp-painel-title"><?= $data['titulo_incomplete_register'] ?></h3>
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

				<!-- <div class="mp-form-group">
					<label class="mp-label"><?= $data['label_nome_incomplete_register'] ?></label>
					<input class="mp-input" type="text" name="nome-completo-incomplete-register" value="" placeholder="<?= $data['placeholder_nome_incomplete_register'] ?>"/>
				</div> -->
				
				<div class="mp-form-group">
					<label class="mp-label"><?= $data['label_email_incomplete_register'] ?></label>
					<input class="mp-input" type="text" name="email-incomplete-register"
						   value=""
						   placeholder="<?= $data['placeholder_email_incomplete_register'] ?>"/>
				</div>

				

				<div class="mp-form-group">
							<label class="mp-label"><?= $data['label_celular_incomplete_register']?></label>
							<input class="mp-input" type="text" name="celular-incomplete-register"
								   value="<?= isset($this->data['fields']['celular-incomplete-register']) ? $this->data['fields']['celular-incomplete-register'] : '' ?>"
								   placeholder="<?= $data['placeholder_celular_incomplete_register']?>"/>
				</div>


				<!-- <div class="mp-form-group">
					<label class="mp-label"><?= $data['label_confirmacao_email_incomplete_register'] ?></label>
					<input class="mp-input" type="text" name="confirm-email-incomplete-register"
						   value=""
						   placeholder="<?= $data['placeholder_confirmacao_email_incomplete_register'] ?>"/>
				</div> -->

				<div class="mp-form-footer">
					<button type="submit" class="mp-btn-primary mp-link"><?= $data['button_incomplete_register'] ?></button>
				</div>
			</form>
		</div>
	</div>
</div>
