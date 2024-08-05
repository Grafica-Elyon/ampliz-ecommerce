<?php
	$atts = shortcode_atts(
		[
			'cadastro_incompleto_telefone_label'        => __('Telefone', MISTERPRINT_PLUGIN_NAME),
		],
		$atts
	);
?>
	<div class="form-group <?=$atts['cadastro_incompleto_telefone_class'];?>">
		<label for="field-telefone"><?=$atts['cadastro_incompleto_telefone_label'];?></label>
		<input type="tel" name="telefone" id="field-telefone" class="form-control tel-mask" required>
	</div>
