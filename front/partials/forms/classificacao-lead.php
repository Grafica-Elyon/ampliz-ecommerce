<?php
	$data = $this->data;
	if ( !isset($data['name']) ) {
		$data['name'] = 'info';
	}
	if ( !isset($data['as-object']) ) {
		$data['as-object'] = false;
	}
	$defaultData = [
		'title' => 'Informações Adicionais',
		'uso' => [
			'label' => 'Para qual finalidade você irá usar os impressos?',
			'name' => $data['name'].($data['as-object'] ? '[uso]' : '-uso'),
			'values' => [
				1 => 'Uso Pessoal',
				0 => 'Revenda'
			],
			'tamanho' => 5
		],
		'faturamento' => [
			'label' => 'Qual seu faturamento mensal com gráficas online?',
			'name' => $data['name'].($data['as-object'] ? '[faturamento]' : '-faturamento'),
			'values' => [
				'até R$ 500,00' => 'até R$ 500,00',
				'De R$ 501,00 a R$ 1.499,00' => 'De R$ 501,00 a R$ 1.499,00',
				'De R$ 1.500,00 a R$ 2.999,00' => 'De R$ 1.500,00 a R$ 2.999,00',
				'De R$ 3.000,00 a R$ 4.999,00' => 'De R$ 3.000,00 a R$ 4.999,00',
				'De R$ 5.000,00 a R$ 9.999,00' => 'De R$ 5.000,00 a R$ 9.999,00',
				'Acima de R$ 10.000,00' => 'Acima de R$ 10.000,00'
			],
			'tamanho' => 5
		],
		'loja-fisica' => [
			'label' => 'Possui loja física?',
			'name' => $data['name'].($data['as-object'] ? '[loja-fisica]' : '-loja-fisica'),
			'values' => [
				1 => 'Sim',
				0 => 'Não'
			],
			'tamanho' => 2
		],
		'funcionarios' => [
			'label' => 'Quantos funcionários possui?',
			'name' => $data['name'].($data['as-object'] ? '[funcionarios]' : '-funcionarios'),
			'values' => [
				'Trabalho sozinho' => 'Trabalho sozinho',
				'Tenho 1 funcionário' => 'Tenho 1 funcionário',
				'Tenho 2 funcionários' => 'Tenho 2 funcionários',
				'Tenho 3 (ou mais) funcionários.' => 'Tenho 3 (ou mais) funcionários.'
			],
			'tamanho' => 3
		],
		'software' => [
			 'label' => 'Qual programa você utiliza para preparar seus arquivos?',
			 'name' => $data['name'].($data['as-object'] ? '[software]' : '-software'),
			 'tamanho' => 5
		]
	];
	$data = array_replace_recursive( $defaultData, $data );
?>

<h5 class="mp-h5 mp-pb-1"><b><?= $data['title']?></b></h5>

<div class="mp-checkbox-group">
	<div class="mp-form-row">
		<?php if ( $data['uso'] ): ?>
			<div class="mp-form-col-<?= intval($data['uso']['tamanho']) ?>">
				<div class="mp-form-group">
					<label class="mp-label"><?= $data['uso']['label'] ?></label>
					<select name="<?= $data['uso']['name'] ?>" class="mp-select" id="<?= $data['uso']['name'] ?>">
						<option value="" disabled><?= $data['uso']['label'] ?></option>
						<?php foreach ($data['uso']['values'] as $key => $value): ?>
							<option value="<?= $key ?>"><?= $value ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $data['faturamento'] ): ?>
			<div class="mp-form-col-<?= intval($data['faturamento']['tamanho']) ?>">
				<div class="mp-form-group">
					<label class="mp-label"><?= $data['faturamento']['label'] ?></label>
					<select name="<?= $data['faturamento']['name'] ?>" class="mp-select" id="<?= $data['faturamento']['name'] ?>">
						<option value="" disabled selected><?= $data['faturamento']['label'] ?></option>
						<?php foreach ($data['faturamento']['values'] as $key => $value): ?>
							<option value="<?= $key ?>"><?= $value ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $data['loja-fisica'] ): ?>
			<div class="mp-form-col-<?= intval($data['loja-fisica']['tamanho']) ?>">
				<div class="mp-form-group">
					<label class="mp-label"><?= $data['loja-fisica']['label'] ?></label>
					<select name="<?= $data['loja-fisica']['name'] ?>" class="mp-select" id="<?= $data['loja-fisica']['name'] ?>">
						<option value="" disabled selected><?= $data['loja-fisica']['label'] ?></option>
						<?php foreach ($data['loja-fisica']['values'] as $key => $value): ?>
							<option value="<?= $key ?>"><?= $value ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $data['funcionarios'] ): ?>
			<div class="mp-form-col-<?= intval($data['funcionarios']['tamanho']) ?>">
				<div class="mp-form-group">
					<label class="mp-label"><?= $data['funcionarios']['label'] ?></label>
					<select name="<?= $data['funcionarios']['name'] ?>" class="mp-select" id="<?= $data['funcionarios']['name'] ?>">
						<option value="" disabled selected><?= $data['funcionarios']['label'] ?></option>
						<?php foreach ($data['funcionarios']['values'] as $key => $value): ?>
							<option value="<?= $key ?>"><?= $value ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $data['software'] ): ?>
			<div class="mp-form-col-<?= intval($data['software']['tamanho']) ?>">
				<div class="mp-form-group">
					<label class="mp-label"><?= $data['software']['label'] ?></label>
						<select name="info-software" class="mp-select" id="info-software">
						<option value="" disabled selected>Selecione uma opção</option>
						<?php foreach(explode(';', $data['formulario_info_software_valores']) as $field) { ?>
							<option value="<?= $field ?>"><?= $field ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>