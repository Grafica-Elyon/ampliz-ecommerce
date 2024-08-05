<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_qtd_funcionarios_label'        => __('Total de Funcionários', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_qtd_funcionarios_class'];?>">
	<label for="field-empresa-qtd-funcionarios"><?=$atts['cadastro_completo_qtd_funcionarios_label'];?>*</label>
	<input type="number" name="empresa-qtd-funcionarios" id="field-empresa-qtd-funcionarios" class="form-control int-mask" required>
</div>
