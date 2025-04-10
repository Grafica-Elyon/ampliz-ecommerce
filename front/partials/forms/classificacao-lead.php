<?php
$data = $this->data;
if (!isset($data['name'])) {
	$data['name'] = 'info';
}
if (!isset($data['as-object'])) {
	$data['as-object'] = false;
}
$defaultData = [
	'title' => 'Informações Adicionais',
];
$data = array_replace_recursive($defaultData, $data);
?>

<h5 class="mp-h5 mp-pb-1"><b><?= $data['title'] ?></b></h5>

<div class="mp-checkbox-group">
	<div class="mp-form-row">
		<?php if ($data['formulario_como_conheceu']): ?>
			<div class="mp-form-col-5">
				<div class="mp-form-group">
					<label class="mp-label"><?= $this->data['formulario_info_referrer'] ?></label>
					<select name="info_referer" class="mp-select" id="info_referer">
						<option value="" disabled selected><?= $data['formulario_info_referrer_placeholder'] ?></option>
						<?php foreach ($data['formulario_como_conheceu'] as $field) { ?>
							<?php $selected = (isset($this->data['fields']['customers_conheceu']) && $this->data['fields']['customers_conheceu'] == $field) ? 'selected="selected"' : ''; ?>
							<option <?= $selected ?> value="<?= $field ?>"><?= $field ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		
	</div>
</div>