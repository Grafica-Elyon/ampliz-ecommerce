<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_newsletter_label'            => __('Deseja assinar a nossa Newsletter?', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_newsletter_sim_label'        => __('Sim', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_newsletter_nao_label'        => __('Não', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group">
	<legend class="col-form-legend"><?= $atts['cadastro_completo_newsletter_label'];?>*</legend>
	<div class="form-check form-check-inline">
		<input type="radio" name="cliente-newsletter" id="field-cliente-newsletter-s" value="1" class="form-check-input" required>
		<label for="field-cliente-newsletter-s" class="form-check-label"><?=$atts['cadastro_completo_newsletter_sim_label'];?></label>
	</div>
	<div class="form-check form-check-inline">
		<input type="radio" name="cliente-newsletter" id="field-cliente-newsletter-n" value="0" class="form-check-input" required>
		<label for="field-cliente-newsletter-n" class="form-check-label"><?=$atts['cadastro_completo_newsletter_nao_label'];?></label>
	</div>
</div>
