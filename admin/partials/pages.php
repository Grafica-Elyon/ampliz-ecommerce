<?php $pages = get_all_pages(); ?>
<?php $options_pages = config('options', 'pages'); ?>
<h2>Paginas do Sistema</h2>
<div class="container">
	<form method="POST" action="<?php echo admin_url('admin-post.php'); ?>">
		<input type="hidden" name="action" value="admin_pages" />
		<?php foreach(config('pages') as $pKey => $page) { ?>
			<div class="mp-form-item">
			<label><?php echo $page['name'] ?>: </label>
			<select name="pages[<?php echo $pKey ?>]">
				<option value="">Selecione</option>
				<?php foreach($pages as $key => $page) { ?>
					<?php $selected = (isset($options_pages[$pKey]) && $key == $options_pages[$pKey]) ? 'selected="selected"' : ''; ?>
					<option <?php echo $selected; ?> value="<?php echo $key ?>"><?php echo $page ?></option>
				<?php } ?>
			</select>
		</div>
		<?php } ?>

		<button type="submit" class="button button-primary button-large">Salvar</button>
	</form>
	<style type="text/css">
		.mp-form-item {
			display: flex;
			width: calc(100% - 40px);
			flex-flow: row wrap;
			justify-content: space-between;
			padding: 10px;
			border-bottom: 1px dashed #7777;
		}
	</style>
</div>
