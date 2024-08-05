<div class="mp-heading">
	<div class="mp-heading-line">
		<h2 class="mp-head"><?= $this->data['params']['title'] ?></h2>
	</div>
	<p><?= $this->data['params']['subtitle'] ?></p>

	<div class="mp-row mp-pt-2 mp-pb-2">
		<div class="mp-col">
			<div class="text-center">
				<?php if (!empty($this->data['params']['thumbnail'])): ?>
					<img src="<?= wp_get_attachment_url($this->data['params']['thumbnail']) ?>"
						 class="mb-img-responsive"
						 alt="">
				<?php endif; ?>
			</div>
		</div>
		<div class="mp-col">
			<div class="mp-accordions">
				<?php if($this->data['tutorial']) { ?>
					<?php $i = 0; ?>
					<?php foreach($this->data['tutorial'] as $tutorial) { ?>
						<div class="mp-accordion <?= ($i == 0) ? 'active' : '' ?>">
							<div class="mp-accordion-header">
								<i class="mp-accordion-icon"></i>
								<span><?php echo $tutorial['title'] ?></span>
							</div>
							<div class="mp-accordion-body">
								<span><?php echo $tutorial['description'] ?></span>
							</div>
						</div>
						<?php $i++ ?>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
