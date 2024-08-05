<?php
$descricao_de_cor = array(
	"1x0" => "(Preto só frente)",
	"1x1" => "(Preto frente e verso)",
	"4x0" => "(Colorido só frente)",
	"4x1" => "(Colorido na frente e cinza no verso)",
	"4x2" => "(Colorido na frente e cinza e amarelo no verso)",
	"4x4" => "(Colorido frente e verso)",
);
?>



<h3 class="mp-painel-title"><?= $this->data['titulo']?></h3>
<div class="mp-listing" data-item="2">
	<?php if(!empty($this->data['items'])) { ?>
		<?php foreach($this->data['items'] as $key => $item) { ?>
			<div class="mp-item">
				<label class="mp-checkbox">
					<?php $checked = ($this->data['item'] == $item || count($this->data['items']) === 1) ? 'checked data-previous-value="checked"' : ''; ?>
					<input type="radio" name="configuration_color" value="<?php echo $item ?>" <?php echo $checked ?> />
					<span class="checkmark"></span>
					<div class="mp-checkbox-label">
						<strong>
							<?php echo $item ?>

							<?php if ( isset($descricao_de_cor[$item]) ): ?>
								<?php echo $descricao_de_cor[$item] ?>
							<?php endif; ?>
						</strong>
					</div>
				</label>
			</div>
		<?php } ?>
	<?php } else { ?>
		<div class="mp-listing-empty"><?= $this->data['painel_2_sem_dados']?></div>
	<?php } ?>
</div>
