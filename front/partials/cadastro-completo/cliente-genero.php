
<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_genero_label'            => __('Escolha o seu Gênero', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_genero_male_label'       => __('Masculino', MISTERPRINT_PLUGIN_NAME),
		'cadastro_completo_genero_female_label'     => __('Feminino', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_genero_class'];?>">
		<legend class="col-form-legend"><?= $atts['cadastro_completo_genero_label'];?>*</legend>

		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="cliente-gender" id="field-cliente-gender-m" value="M" required>
			<label for="field-cliente-gender-m" class="form-check-label"><?=$atts['cadastro_completo_genero_male_label'];?></label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="radio" name="cliente-gender" id="field-cliente-gender-f" value="F" required>
			<label for="field-cliente-gender-f" class="form-check-label"><?=$atts['cadastro_completo_genero_female_label'];?></label>
		</div>
	</div>

