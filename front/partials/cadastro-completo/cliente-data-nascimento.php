<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_nascimento_label'        => __('Data de Nascimento', MISTERPRINT_PLUGIN_NAME),
	],
	$atts
);
?>
<div class="form-group <?=$atts['cadastro_completo_nascimento_class'];?>">
	<label for="field-cliente-dob"><?=$atts['cadastro_completo_nascimento_label'];?>*</label>
	<input type="date" name="cliente-dob" id="field-cliente-dob" class="form-control date-mask" required>
</div>
