<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_logradouro_cidade_label'         => __('Cidade', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_logradouro_cidade_placeholder'   => __('Digite a sua cidade', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_logradouro_cidade_class'];?>">
	<label for="field-endereco-city"><?=$atts['cadastro_completo_logradouro_cidade_label'];?>*</label>
	<input type="text" name="endereco-city" id="field-endereco-city" class="form-control" placeholder="<?=$atts['cadastro_completo_logradouro_cidade_placeholder'];?>" required>
</div>
