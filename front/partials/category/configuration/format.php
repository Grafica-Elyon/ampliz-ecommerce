<h3 class="mp-painel-title"><?= $this->data['titulo']?></h3>
<div class="mp-listing" data-item="2">
	<?php if(!empty($this->data['items']['formatos'])) { ?>
		<?php foreach($this->data['items']['formatos'] as $key => $item) { ?>
			<div class="mp-item">
				<label class="mp-checkbox">
					<?php $checked = ($this->data['item'] == $item) ? 'checked' : ''; ?>
					<input type="radio" name="configuration_format" value="<?php echo $item ?>" <?php echo $checked ?> />
					<span class="checkmark"></span>
					<div class="mp-checkbox-label"><strong><?php echo $item ?> cm</strong></div>
				</label>
			</div>
		<?php } ?>

		<?php if(!empty($this->data['items']['sobMedida'])) { ?>
			<div class="mp-item">
				<label class="mp-checkbox">
					<?php $checked = ($this->data['item'] == 'custom') ? 'checked' : ''; ?>
					<input type="radio" name="configuration_format" value="custom" <?php echo $checked ?> />
					<span class="checkmark"></span>
					<div class="mp-checkbox-label"><strong>Sob medida</strong></div>
				</label>
				<div class="mp-sob-medida" <?= ($this->data['item'] == 'custom') ? '' : 'style="display: none;"' ?> >
					<div class="mp-left-input">
						<input type="text" class="mp-input" name="sob_medida_width"
							data-min="<?php echo $this->data['items']['largura_minima'] ?>"
							data-max="<?php echo $this->data['items']['largura_maxima'] ?>"
							value="<?= $this->data['custom_width'] ?>" />
					</div>
					<div class="mp-right-input">
						<input type="text" class="mp-input" name="sob_medida_height"
							data-min="<?php echo $this->data['items']['altura_minima'] ?>"
							data-max="<?php echo $this->data['items']['altura_maxima'] ?>"
							value="<?= $this->data['custom_height'] ?>" />
					</div>
					<div class="mp-message mp-text-right">
						O formato minimo é: <?php echo $this->data['items']['largura_minima'] ?>x<?php echo $this->data['items']['altura_minima'] ?><br />
						<?php if(!empty($this->data['items']['largura_maxima']) && !empty($this->data['items']['altura_maxima'])) { ?>
							O formato maximo é: <?php echo $this->data['items']['largura_maxima'] ?>x<?php echo $this->data['items']['altura_maxima'] ?><br />
						<?php } ?>
					</div>
					<div class="mp-sob-medida-bottom">
						<button type="button" id="mp-sob-medida-send" class="mp-btn-sm mp-btn-primary">Enviar</button>
					</div>
				</div>
			</div>
		<?php } ?>
	<?php } else { ?>
		<div class="mp-listing-empty"><?= $this->data['painel_2_sem_dados']?></div>
	<?php } ?>
</div>
