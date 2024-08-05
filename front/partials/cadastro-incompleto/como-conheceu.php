<?php
$atts = shortcode_atts(
	[
		'cadastro_incompleto_como_conheceu_label'        => __('Como nos Conheceu?', MISTERPRINT_PLUGIN_NAME),
		'cadastro_incompleto_como_conheceu_placeholder'   => __('Descreva como nos conheceu', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_incompleto_como_conheceu_class'];?>">
	<label for="field-conheceu"><?=$atts['cadastro_incompleto_como_conheceu_label'];?></label>
	<textarea name="comoConheceu" id="field-conheceu" class="form-control" placeholder="<?=$atts['cadastro_incompleto_como_conheceu_placeholder'];?>" required></textarea>
</div>
