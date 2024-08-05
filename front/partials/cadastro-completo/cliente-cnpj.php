<?php
	$atts = shortcode_atts(
		[
			'cadastro_completo_cnpj_label'        => __('CNPJ', MISTERPRINT_PLUGIN_NAME),
		],
		$atts
	);
?>
<div class="form-group <?=$atts['cadastro_completo_cnpj_class'];?>">
	<label for="field-cliente-cnpj"><?=$atts['cadastro_completo_cnpj_label'];?>*</label>
	<input name="cliente-cnpj" type="text" name="field-cnpj" id="field-cliente-cnpj" class="form-control cnpj-mask" required>
</div>
