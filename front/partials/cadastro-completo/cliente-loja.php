<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_loja_label'        => __('Loja', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_loja_class'];?>">
	<label for="field-cliente-loja"><?=$atts['cadastro_completo_loja_label'];?>*</label>
	<input type="text" name="cliente-loja" id="field-cliente-loja" maxlength="4" class="form-control" required>
	<class class="mp-maxchar">Limite de 04 caracteres</class>
</div>
