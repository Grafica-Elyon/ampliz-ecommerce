<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_cpf_label'           => __('CPF', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_cpf_class'];?>">
	<label for="field-cliente-cpf"><?=$atts['cadastro_completo_cpf_label'];?>*</label>
	<input name="cliente-cpf" type="text" name="field-cpf" id="field-cliente-cpf" class="form-control cpf-mask" required>
</div>
