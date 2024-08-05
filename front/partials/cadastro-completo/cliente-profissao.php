<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_profissao_label'        => __('Profissão', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_profissao_placeholder'   => __('Digite a sua profissão', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_profissao_class'];?>">
	<label for="field-cliente-profissao"><?=$atts['cadastro_completo_profissao_label'];?>*</label>
	<input type="text" name="cliente-profissao" id="field-cliente-profissao" class="form-control" placeholder="<?=$atts['cadastro_completo_profissao_placeholder'];?>" required>
</div>
