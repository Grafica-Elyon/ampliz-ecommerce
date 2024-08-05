<?php
$atts = shortcode_atts(
	[
		'client_authentication_pass_label'        => __('Senha', MISTERPRINT_PLUGIN_NAME),
		'client_authentication_pass_placeholder'  => __('Digite a sua senha.', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['client_authentication_pass_class'];?>">
	<label for="field-pass"><?=$atts['client_authentication_pass_label'];?>:</label>
	<input type="password" name="senha" class="form-control" value="W]_J#OJ5Mh" placeholder="<?=$atts['client_authentication_pass_placeholder'];?>" required>
</div>