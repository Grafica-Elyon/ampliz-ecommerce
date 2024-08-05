<?php
	$atts = shortcode_atts(
		[
			'cadastro_incompleto_email_label'        => __('Email', MISTERPRINT_PLUGIN_NAME),
			'cadastro_incompleto_email_placeholder'   => __('Digite o seu email', MISTERPRINT_PLUGIN_NAME),
		],
		$atts
	);
?>
<div class="form-group <?=$atts['cadastro_incompleto_email_class'];?>">
	<label for="field-email"><?=$atts['cadastro_incompleto_email_label'];?>*</label>
	<input type="email" name="email" id="field-email" class="form-control email-mask" required placeholder="<?=$atts['cadastro_incompleto_email_placeholder'];?>">
</div>
