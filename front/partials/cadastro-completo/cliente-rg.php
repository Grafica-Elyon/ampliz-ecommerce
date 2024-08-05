<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_rg_label'           => __('RG', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
	<div class="form-group <?=$atts['cadastro_completo_rg_class'];?>"">
		<label for="field-endereco-rg"><?=$atts['cadastro_completo_rg_label'];?>*</label>
		<input type="text" name="endereco-rg" id="field-endereco-rg" class="form-control rg-mask" required>
	</div>
