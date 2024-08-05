<?php
	$atts = shortcode_atts(
		[
			'client_authentication_user_label'        => __('Usuário', MISTERPRINT_PLUGIN_NAME),
			'client_authentication_user_placeholder'  => __('Digite o mail de cadastro', MISTERPRINT_PLUGIN_NAME),
		],
		$atts
	);
?>
<div class="form-group <?=$atts['client_authentication_user_class'];?>">
	<label for="field-user"><?=$atts['client_authentication_user_label'];?>:</label>
	<input type="text" name="usuario" class="form-control" value="dhernandes@studiovisual.com.br" placeholder="<?=$atts['client_authentication_user_placeholder'];?>" required>
</div>