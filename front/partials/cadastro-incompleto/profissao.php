<?php
$atts = shortcode_atts(
	[
		'cadastro_incompleto_profissao_label'        => __('Profissão', MISTERPRINT_PLUGIN_NAME),
		'cadastro_incompleto_profissao_placeholder'   => __('Digite a sua profissão', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_incompleto_profissao_class'];?>">
	<label for="field-profissao"><?=$atts['cadastro_incompleto_profissao_label'];?></label>
	<input type="text" name="profissao" id="field-profissao" class="form-control" placeholder="<?=$atts['cadastro_incompleto_profissao_placeholder'];?>" required>
</div>
