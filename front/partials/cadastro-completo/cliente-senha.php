<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_senha_label'                     => __('Senha', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_confirma_senha_label'            => __('Confirme a senha', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_senha_placeholder'               => __('Digite a sua senha', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_confirma_senha_placeholder'      => __('Redigite a sua senha', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
	<div class="form-group <?=$atts['cadastro_completo_senha_class'];?>">
		<label for="field-cliente-password"><?=$atts['cadastro_completo_senha_label'];?>*</label>
		<input type="password" name="cliente-password" id="field-cliente-password" class="form-control showpassword" placeholder="<?=$atts['cadastro_completo_senha_placeholder'];?>" required>
	</div>
	<div class="form-group">
		<label for="field-cliente-password-confirmation"><?=$atts['cadastro_completo_confirma_senha_label'];?>*</label>
		<input type="password" name="cliente-password-confirmation" id="field-cliente-password-confirmation" class="form-control showpassword" placeholder="<?=$atts['cadastro_completo_confirma_senha_placeholder'];?>" required>
	</div>
