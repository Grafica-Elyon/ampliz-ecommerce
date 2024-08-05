<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_cargo_label'        => __('Cargo', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_cargo_placeholder'   => __('Digite o seu cargo.', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_cargo_class'];?>">
	<label for="field-empresa-cargo"><?=$atts['cadastro_completo_cargo_label'];?>*</label>
	<input type="text" name="empresa-cargo" id="field-empresa-cargo" class="form-control" placeholder="<?=$atts['cadastro_completo_cargo_placeholder'];?>" required>
</div>
