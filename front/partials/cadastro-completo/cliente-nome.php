<?php
	$atts = shortcode_atts(
		[
			'cadastro_completo_nome_label'        => __('Nome', MISTERPRINT_PLUGIN_NAME),
			'cadastro_completo_nome_placeholder'   => __('Digite o seu nome', MISTERPRINT_PLUGIN_NAME),
		],
		$atts
	);
?>
	<div class="form-group <?=$atts['cadastro_completo_nome_class'];?>">
		<label for="field-cliente-nome"><?=$atts['cadastro_completo_nome_label'];?>*</label>
		<input type="text" name="cliente-nome" id="field-cliente-nome" class="form-control" placeholder="<?=$atts['cadastro_completo_nome_placeholder'];?>" required>
	</div>
