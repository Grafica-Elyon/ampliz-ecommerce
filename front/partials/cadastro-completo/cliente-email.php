<?php
	$atts = shortcode_atts(
		[
			'cadastro_completo_email_label'         => __('Email', MISTERPRINT_PLUGIN_NAME),
			'cadastro_completo_email_placeholder'   => __('Digite o seu email', MISTERPRINT_PLUGIN_NAME),
		],
		$atts
	);
?>
	<div class="form-group <?=$atts['cadastro_completo_email_class'];?>">
		<label for="field-cliente-email"><?=$atts['cadastro_completo_email_label'];?>*</label>
		<input type="email" name="cliente-email" id="field-cliente-email" class="form-control email-mask" required placeholder="<?=$atts['cadastro_completo_email_placeholder'];?>" required>
	</div>
