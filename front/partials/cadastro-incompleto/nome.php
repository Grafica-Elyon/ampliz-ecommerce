<?php
	$atts = shortcode_atts(
		[
			'cadastro_incompleto_nome_label'        => __('Nome', MISTERPRINT_PLUGIN_NAME),
			'cadastro_incompleto_nome_placeholder'   => __('Digite o seu nome', MISTERPRINT_PLUGIN_NAME),
		],
		$atts
	);
?>
<div class="form-group <?=$atts['cadastro_incompleto_nome_class'];?>">
	<label for="field-nome"><?=$atts['cadastro_incompleto_nome_label'];?>*</label>
	<input type="text" name="nome" id="field-nome" class="form-control" required placeholder="<?=$atts['cadastro_incompleto_nome_placeholder'];?>">
</div>
