<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_agree_label'        => __('Declaro que li, tenho ciência e concordo plenamente com os <strong>Termos de Uso</strong> do site.', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_agree_class'];?>">
	<div class="form-check">
		<input type="checkbox" name="cliente-agree" id="field-cliente-agree" value="1" class="form-check-input" required>
		<label for="field-cliente-agree" class="form-check-label"><?=$atts['cadastro_completo_agree_label'];?>*</label>
	</div>
</div>
