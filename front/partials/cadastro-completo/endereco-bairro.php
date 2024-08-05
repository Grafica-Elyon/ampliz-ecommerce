<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_logradouro_bairro_label'         => __('Bairro', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_logradouro_bairro_placeholder'   => __('Digite o seu bairro', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_logradouro_bairro_class'];?>">
	<label for="field-endereco-suburb"><?=$atts['cadastro_completo_logradouro_bairro_label'];?>*</label>
	<input type="text"  name="endereco-suburb" id="field-endereco-suburb" class="form-control" placeholder="<?=$atts['cadastro_completo_logradouro_bairro_placeholder'];?>" required>
</div>
