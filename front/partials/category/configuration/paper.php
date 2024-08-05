<h3 class="mp-painel-title"><?= $this->data['titulo']?></h3>
<div class="mp-listing" data-item="2">
	<?php if(!empty($this->data['items'])) { ?>
		<?php foreach($this->data['items'] as $key => $item) { ?>
			<div class="mp-item">
				<label class="mp-checkbox">
					<?php $checked = ($this->data['item'] == ($item['slug'].'-'.$item['gramatura']) || count($this->data['items']) === 1) ? 'checked data-previous-value="checked"' : ''; ?>
					<input type="radio" name="configuration_paper" value="<?= $item['slug'].'-'.$item['gramatura'] ?>" <?= $checked ?> data-value="<?= $item['descricao'] ?> <?= $item['gramatura'] ?>g/m²" />
					<span class="checkmark"></span>
					<div class="mp-checkbox-label"><strong><?= $item['descricao'] ?> <?= $item['gramatura'] ?>g/m²</strong></div>
				</label>
			</div>
		<?php } ?>
	<?php } else { ?>
		<div class="mp-listing-empty"><?= $this->data['painel_2_sem_dados']?></div>
	<?php } ?>
</div>
