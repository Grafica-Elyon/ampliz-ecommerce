<?php
	$atts = shortcode_atts(
		[
			'cadastro_completo_telefone_label'        => __('Telefone', MISTERPRINT_PLUGIN_NAME),
		],
		$atts
	);
?>
	<div class="form-group <?=$atts['cadastro_completo_telefone_class'];?>">
		<label for="field-cliente-telefone"><?=$atts['cadastro_completo_telefone_label'];?>*</label>
		<input type="tel" name="cliente-telefone" id="field-cliente-telefone" class="form-control tel-mask">  <!-- required -->
	</div>
