<?php
$atts = shortcode_atts(
	[
		'cadastro_incompleto_cep_label'        => __('CEP', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_incompleto_cep_class'];?>">
	<label for="field-endereco-postcode"><?=$atts['cadastro_incompleto_cep_label'];?>*</label>
	<input type="text" name="endereco-postcode" id="field-endereco-postcode" class="form-control cep-mask" required>
</div>
