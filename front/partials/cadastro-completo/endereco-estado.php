<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_logradouro_estado_label'         => __('Estado', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_logradouro_estado_placeholder'   => __('Selecione o seu estado', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_logradouro_estado_class'];?>">
	<label for="field-endereco-state"><?=$atts['cadastro_completo_logradouro_estado_label'];?>*</label><br/>
	<input type="text"name="endereco-state" id="field-endereco-state" class="form-control" placeholder="<?=$atts['cadastro_completo_logradouro_estado_placeholder'];?>" required>
</div>
