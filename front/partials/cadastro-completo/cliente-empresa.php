<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_empresa_label'        => __('Empresa', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_empresa_placeholder'   => __('Digite o nome da sua empresa.', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_empresa_class'];?>">
	<label for="field-cliente-company"><?=$atts['cadastro_completo_empresa_label'];?>*</label>
	<input type="text" name="cliente-company" id="field-cliente-company" class="form-control" required placeholder="<?=$atts['cadastro_completo_empresa_placeholder'];?>" required>
</div>
