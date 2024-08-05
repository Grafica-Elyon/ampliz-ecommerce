<?php
	$atts = shortcode_atts(
		[
			'cadastro_completo_como_conheceu_label'        => __('Como nos Conheceu?', MISTERPRINT_PLUGIN_NAME),
			'cadastro_completo_como_conheceu_placeholder'   => __('Descreva como nos conheceu', MISTERPRINT_PLUGIN_NAME),
		],
		$atts
	);
?>
<div class="form-group <?=$atts['cadastro_completo_como_conheceu_class'];?>">
	<label for="field-cliente-como-conheceu"><?=$atts['cadastro_completo_como_conheceu_label'];?>*</label>
	<textarea name="cliente-como-conheceu" id="field-cliente-como-conheceu" class="form-control" placeholder="<?=$atts['cadastro_completo_como_conheceu_placeholder'];?>" required></textarea>
</div>
