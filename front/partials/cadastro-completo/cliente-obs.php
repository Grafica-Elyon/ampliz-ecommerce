<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_observacoes_label'           => __('Observacoes', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_observacoes_placeholder'     => __('Digite o seu observacoes', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_observacoes_class'];?>">
	<label for="field-cliente-obs"><?=$atts['cadastro_completo_observacoes_label'];?>*</label>
	<textarea name="cliente-obs" id="field-cliente-obs" cols="30" rows="10" class="form-control" placeholder="<?=$atts['cadastro_completo_observacoes_placeholder'];?>" required></textarea>
</div>
