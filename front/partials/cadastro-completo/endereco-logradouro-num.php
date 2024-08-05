<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_num_logradouro_label'        => __('Número', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_num_logradouro_class'];?>">
	<label for="field-endereco-street-number"><?=$atts['cadastro_completo_num_logradouro_label'];?>*</label>
	<input type="number" name="endereco-street-number" id="field-endereco-street-number" class="form-control int-mask" required>
</div>
