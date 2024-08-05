<?php $option_color = config('options', 'main_color'); ?>

<div class="wrap">
	<?php if (isset($_GET['save_company'])) : ?>
		<div class="notice notice-success is-dismissible"><p><?php _e('As informações da empresa foram salvas!'); ?></p></div>
	<?php endif; ?>
	<?php if (isset($_GET['clear'])) : ?>
		<div class="notice notice-success is-dismissible"><p><?php _e('O cache foi apagado!'); ?></p></div>
	<?php endif; ?>
	<?php if (isset($_GET['updated'])) : ?>
		<div class="notice notice-success is-dismissible"><p><?php _e('Produtos sincronizados!'); ?></p></div>
	<?php endif; ?>
	<h1 class="wp-heading-inline">Opções do plugin</h1>
	<form method="POST" action="<?php echo admin_url('admin-post.php'); ?>">
		<input type="hidden" name="action" value="main_color" />

		<label for="color">Cor primaria: </label>
		<input type="color" name="color" id="color" value="<?= $option_color?>">

		<button type="submit" class="button button-primary button-large">Salvar</button>
	</form>
	<br>
	<form method="POST" action="<?php echo admin_url('admin-post.php'); ?>">
		<input type="hidden" name="action" value="delete_transient" />
		<button type="submit" class="button button-primary button-large">Apagar cache do plugin</button>
	</form>
	<br /><br />
	<h2>Social Links</h2>
	<div class="mp-row">
		<div class="mp-col-3">
			<form method="POST" action="<?php echo admin_url('admin-post.php'); ?>" class="form">
				<input type="hidden" name="action" value="social_links" />

				<div class="input-block">
					<label>Facebook</label>
					<input type="text" class="input-control" name="facebook_link"
						value="<?php echo isset($this->data['social_links']['facebook']) ? $this->data['social_links']['facebook'] : '' ?>" />
				</div>

				<div class="input-block">
					<label>Twitter</label>
					<input type="text" class="input-control" name="twitter_link"
						value="<?php echo isset($this->data['social_links']['facebook']) ? $this->data['social_links']['twitter'] : '' ?>" />
				</div>

				<div class="input-block">
					<label>Instagram</label>
					<input type="text" class="input-control" name="instagram_link"
						value="<?php echo isset($this->data['social_links']['facebook']) ? $this->data['social_links']['instagram'] : '' ?>" />
				</div>

				<div class="input-block">
					<label>Youtube</label>
					<input type="text" class="input-control" name="youtube_link"
					   value="<?php echo isset($this->data['social_links']['facebook']) ? $this->data['social_links']['youtube'] : '' ?>" />
				</div>

				<button type="submit" class="button button-primary button-large">Salvar dados da empresa</button>
			</form>
		</div>
	</div>
</div>
