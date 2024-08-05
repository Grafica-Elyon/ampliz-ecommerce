<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_atividade_label'        => __('Atividade', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_atividade_placeholder'   => __('Digite a sua atividade.', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
	<div class="form-group <?=$atts['cadastro_completo_atividade_class'];?>">
		<label for="field-atividade-atividade"><?=$atts['cadastro_completo_atividade_label'];?>*</label>
		<input type="text" name="atividade-atividade" id="field-atividade-atividade" class="form-control" placeholder="<?=$atts['cadastro_completo_atividade_placeholder'];?>" required>
	</div>
