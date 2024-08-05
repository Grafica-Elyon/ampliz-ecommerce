<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_facebook_label'        => __('Facebook', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_facebook_placeholder'   => __('Digite o seu facebook', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_facebook_class'];?>">
	<label for="field-comunicacao-facebook"><?=$atts['cadastro_completo_facebook_label'];?>*</label>
	<input type="text" name="comunicacao-facebook" id="field-comunicacao-facebook" class="form-control" placeholder="<?=$atts['cadastro_completo_facebook_placeholder'];?>" required>
</div>
