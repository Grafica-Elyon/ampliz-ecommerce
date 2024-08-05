<section class="mp-mb-3 mp-pb-4 mp-container">
	<div class="mp-heading">
		<div class="mp-heading-line">
			<h2 class="mp-head"><?= $this->data['params']['title'] ?></h2>
		</div>
		<p><?= $this->data['params']['subtitle'] ?></p>
	</div>
	<div class="text-center">
		<?php if($this->data['vantagens']) { ?>
			<div class="mp-card-list">
				<div class="mp-card-list-image mp-card-list-image-text">
					<span>gráficas online</span>
				</div>
				<div class="mp-card-body">
					<?php foreach($this->data['vantagens']['online'] as $item) { ?>
						<div class="mp-card-list-item">
							<i class="icon-<?php echo ($item['vantagem'] == '1') ? 'check' : 'close'; ?>"></i>
							<span><?php echo $item['title']; ?></span>
						</div>
					<?php } ?>
				</div>
				<div class="mp-card-footer"></div>
			</div>

			<div class="mp-card-list active">
				<div class="mp-card-list-image">
					<img src=" <?= config('plugin', 'url') ?>front/assets/imgs/logo.png" class="mb-img-responsive"
						alt="">
				</div>
				<div class="mp-card-body">
					<?php foreach($this->data['vantagens']['misterprint'] as $item) { ?>
						<div class="mp-card-list-item">
							<i class="icon-<?php echo ($item['vantagem'] == '1') ? 'check' : 'close'; ?>"></i>
							<span><?php echo $item['title']; ?></span>
						</div>
					<?php } ?>
				</div>
				<div class="mp-card-footer">
					<a href="#" class="mp-btn mp-btn-primary">Configurar produto</a>
				</div>
			</div>

			<div class="mp-card-list">
				<div class="mp-card-list-image mp-card-list-image-text">
					<span>tradicionais</span>
				</div>
				<div class="mp-card-body">
					<?php foreach($this->data['vantagens']['tradicionais'] as $item) { ?>
						<div class="mp-card-list-item">
							<i class="icon-<?php echo ($item['vantagem'] == '1') ? 'check' : 'close'; ?>"></i>
							<span><?php echo $item['title']; ?></span>
						</div>
					<?php } ?>
				</div>
				<div class="mp-card-footer"></div>
			</div>
		<?php } ?>
	</div>
</section>
