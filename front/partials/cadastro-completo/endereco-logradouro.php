<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_logradouro_label'        => __('Logradouro', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_logradouro_placeholder'   => __('Digite o seu logradouro', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_logradouro_class'];?>">
	<label for="field-endereco-street-address"><?=$atts['cadastro_completo_logradouro_label'];?>*</label>
	<input type="text" name="endereco-street-address" id="field-endereco-street-address" class="form-control" placeholder="<?=$atts['cadastro_completo_logradouro_placeholder'];?>" required>
</div>
