<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_aparelho_label'        => __('Aparelho', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_aparelho_placeholder'   => __('Digite o seu aparelho', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_aparelho_class'];?>">
	<label for="field-comunicacao-aparelho"><?=$atts['cadastro_completo_aparelho_label'];?>*</label>
	<input type="text" name="comunicacao-aparelho" id="field-comunicacao-aparelho" class="form-control" placeholder="<?=$atts['cadastro_completo_aparelho_placeholder'];?>" required>
</div>
