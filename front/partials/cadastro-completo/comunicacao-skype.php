<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_skype_label'        => __('Skype', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_skype_placeholder'   => __('Digite o seu skype', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_skype_class'];?>">
	<label for="field-comunicacao-skype"><?=$atts['cadastro_completo_skype_label'];?>*</label>
	<input type="text" name="comunicacao-skype" id="field-comunicacao-skype" class="form-control" placeholder="<?=$atts['cadastro_completo_skype_placeholder'];?>" required>
</div>
