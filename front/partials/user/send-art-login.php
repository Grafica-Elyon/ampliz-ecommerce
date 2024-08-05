<?php
use MisterPrint\Support\View;
$data = $this->data['params'];

?>
<div class="mp-row">
	<div class="mp-col-3"></div>
	<div class="mp-col-4">
		<input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />
		<div class="mp-send-art">
			<form method="POST" class="mp-form">
				<input type="hidden" name="action" value="mp_sent_art_login" />
				<input type="hidden" name="pedido" value="<?php echo $this->data['pedido'] ?>" />

				<?php echo (new View('misc/errors', [
					'errors' => (isset($this->data['errors'])) ? $this->data['errors'] : []
				]))->get() ?>


				<div class="mp-heading">
					<div class="mp-heading-line">
						<h2 class="mp-head">Entrar</h2>
					</div>
				</div>
				<br />
				<div class="mp-form-group">
					<label class="mp-label">Email:</label>
					<input class="mp-input" type="text" name="email"
						value="<?php echo isset($this->data['email']) ? $this->data['email'] : '' ?>" />
				</div>

				<div class="mp-form-group">
					<label class="mp-label">Senha: </label>
					<input class="mp-input" type="password" name="password" value="" />
				</div>

				<div class="mp-form-footer">
					<button type="submit" class="mp-btn-primary mp-link" >Entrar</button>
				</div>
			</form>
		</div>
	</div>
</div>
