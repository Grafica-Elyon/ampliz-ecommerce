<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_celular_label'        => __('Celular', MISTERPRINT_PLUGIN_NAME)
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_celular_class'];?>">
	<label for="field-cliente-celular"><?=$atts['cadastro_completo_celular_label'];?>*</label>
	<input type="tel" name="cliente-celular" id="field-cliente-celular" class="form-control tel-mask" required>
</div>
