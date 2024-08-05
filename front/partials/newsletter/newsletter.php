<?php $data = $this->data['params']; ?>
<input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />

<?php if(isset($this->data['sent']) && $this->data['sent']) { ?>
	<div class="mp-newsletter">
		<p class="mp-success">Newsletter enviado com sucesso!</p>
	</div>
<?php } else { ?>
	<div class="mp-newsletter">
		<h2><?= $this->data['params']['titulo'] ?></h2>

		<?php if(isset($this->data['sent']) && !$this->data['sent']) { ?>
			<p class="mp-error">Erro ao enviar, tente novamente mais tarde.</p>
		<?php } ?>
		<form class="mp-newsletter-form mp-form">
			<input type="email" name="email" class="mp-input" placeholder="<?= $this->data['params']['placeholder'] ?>" />
			<br />
			<button type="submit" class="mp-btn-primary wide"><?= $this->data['params']['botao'] ?></button>
		</form>
	</div>
<?php } ?>
