<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_twitter_label'        => __('Twitter', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_twitter_placeholder'   => __('Digite o seu twitter', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_twitter_class'];?>">
	<label for="field-comunicacao-twitter"><?=$atts['cadastro_completo_twitter_label'];?>*</label>
	<input type="text" name="comunicacao-twitter" id="field-comunicacao-twitter" class="form-control" placeholder="<?=$atts['cadastro_completo_twitter_placeholder'];?>" required>
</div>
