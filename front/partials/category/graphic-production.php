<section class="mp-pb-3">
	<div class="mp-heading mp-pb-3">
		<div class="mp-heading-line">
			<h2 class="mp-head"><?= $this->data['params']['title'] ?></h2>
		</div>
		<p><?= $this->data['params']['subtitle'] ?></p>
	</div>

	<div class="mp-row">
		<div class="mp-col">
			<?php if(!empty($this->data['producao']['imagens'])) { ?>
				<div class="owl-carousel owl-theme mp-default-carousel graphic-production">
					<?php foreach($this->data['producao']['imagens'] as $imagem) { ?>
						<div class="item">
							<img src="<?= $imagem ?>" class="mb-img-responsive" alt="" />
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
		<div class="mp-col">
			<div class="mp-tex-default-lg mp-pb-2">
				<?php echo (isset($this->data['producao']['description'])) ? $this->data['producao']['description'] : ''; ?>
			</div>
		</div>
	</div>
</section>
