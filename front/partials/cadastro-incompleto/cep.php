<?php
$atts = shortcode_atts(
	[
		'cadastro_incompleto_cep_label'        => __('CEP', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_incompleto_cep_class'];?>">
	<label for="field-cep"><?=$atts['cadastro_incompleto_cep_label'];?></label>
	<input type="text" name="cep" id="field-cep" class="form-control cep-mask" required>
</div>
