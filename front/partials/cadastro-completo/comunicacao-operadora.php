<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_operadora_label'        => __('Operadora', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_operadora_placeholder'   => __('Digite o nome da sua operadora.', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group  <?=$atts['cadastro_completo_operadora_class'];?>">
	<label for="field-comunicacao-operadora"><?=$atts['cadastro_completo_operadora_label'];?>*</label>
	<input type="text" name="comunicacao-operadora" id="field-comunicacao-operadora" class="form-control" placeholder="<?=$atts['cadastro_completo_operadora_placeholder'];?>" required>
</div>
