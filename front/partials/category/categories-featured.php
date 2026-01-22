<?php

use MisterPrint\Support\View;

$data = $this->data['params'];
$compras = $this->data['compras'];
?>
<?php //mp-nav precisa ter um 'data-tab="mp-tab-0"' que linka com o id do mp-tab-content
?>
<div class="mp-heading">
	<div class="mp-heading-line">
		<h2 class="mp-head"><?= $data['titulo'] ?></h2>
	</div>
	<p><?= $data['subtitulo'] ?></p>
</div>
<br /><br />
<div class="mp-tab">
	<div class="mp-tab-nav">
		<ul class="mp-nav">
			<li class="active" data-tab="mp-tab-all"><?= $data['todos'] ?></li>
			<?php if (isset($this->data['new']) && !empty($this->data['new'])) : ?>
				<li data-tab="mp-tab-1"><?= $data['lancamentos'] ?></li>
			<?php endif; ?>
			<?php if (isset($this->data['favorite']) && !empty($this->data['favorite'])) : ?>
				<li data-tab="mp-tab-favorite"><?= $data['favoritos'] ?></li>
			<?php endif; ?>

			<?php if (isset($this->data['offer']) && !empty($this->data['offer'])) : ?>
				<li data-tab="mp-tab-2"><?= $data['ofertas'] ?></li>
			<?php endif; ?>

			<?php if (isset($this->data['especial']) && !empty($this->data['especial'])) : ?>
				<li data-tab="mp-tab-especial"><?= $data['especial'] ?></li>
			<?php endif; ?>

			<?php if (isset($this->data['balcao']) && !empty($this->data['balcao'])) : ?>
				<li data-tab="mp-tab-balcao"><?= $data['balcao'] ?></li>
			<?php endif; ?>

			<?php if (is_balcony()) : ?>
				<li data-tab="mp-tab-art-creation"><?= $data['art_creation'] ?></li>
			<?php endif; ?>
		</ul>
	</div>
	<div class="mp-tab-contents">
		<div class="mp-tab-content active" id="mp-tab-all">
			<div class="mp-tab-header">
				<span>Produtos</span>
			</div>
			<div class="mp-tab-body">
				<div class="mp-row">
					<div class="mp-listing">
						<?php foreach ($this->data['all'] as $category) : ?>
							<div class="mp-item">
								<?php echo (new View('category/card', $category))->get() ?>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>

		<?php if (user()->isLogged()) { ?>
			<?php foreach ($this->data['favorite'] as &$item) {
				$item = json_decode(json_encode($item), true);
			} ?>
			<div class="mp-tab-content" id="mp-tab-favorite">
				<div class="mp-tab-header">
					<span>Favoritos</span>
				</div>
				<div class="mp-tab-body">
					<div class="mp-row">
						<div class="mp-listing">
							<?php $i = 0; ?>
							<?php foreach ($this->data['favorite'] as $category) { ?>
								<div class="mp-item">
									<?php echo (new View('category/favorite-card', $category))->get(); ?>
								</div>
								<?php $i++; ?>
								<?php if ($i % 4 == 0) { ?>
									<br class="clear mp-hide-carousel" />
								<?php } ?>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<!-- <div class="mp-tab-content" id="mp-tab-0">
			<div class="mp-tab-header">
				<span>Mais visitados</span>
			</div>
			<div class="mp-tab-body">
				<div class="mp-row">
					<div class="mp-listing">

						<?php foreach ($this->data['most_visited'] as $category) : ?>
							<div class="mp-item">
								<?php echo (new View('category/card', $category))->get() ?>
							</div>
							<?php $i++; ?>
							<?php if ($i % 4 == 0) { ?>
								<br class="clear mp-hide-carousel" />
							<?php } ?>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div> -->

		<?php if (isset($this->data['new']) && !empty($this->data['new'])) : ?>
			<div class="mp-tab-content" id="mp-tab-1">
				<div class="mp-tab-header">
					<span>Lançamentos</span>
				</div>
				<div class="mp-tab-body">
					<div class="mp-row">
						<div class="mp-listing">

							<?php foreach ($this->data['new'] as $category) : ?>
								<div class="mp-item">
									<?php echo (new View('category/card', $category))->get() ?>
								</div>

							<?php endforeach ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if (isset($this->data['offer']) && !empty($this->data['offer'])) : ?>
			<div class="mp-tab-content" id="mp-tab-2">
				<div class="mp-tab-header">
					<span>Ofertas</span>
				</div>
				<div class="mp-tab-body">
					<div class="mp-row">
						<div class="mp-listing">
							<?php foreach ($this->data['offer'] as $category) : ?>
								<div class="mp-item">
									<?php echo (new View('category/card', $category))->get() ?>
								</div>
							<?php endforeach ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($this->data['especial']) && !empty($this->data['especial'])) : ?>
			<div class="mp-tab-content" id="mp-tab-especial">
				<div class="mp-tab-header">
					<span><?= $data['especial'] ?></span>
				</div>
				<div class="mp-tab-body">
					<div class="mp-row">
						<div class="mp-listing">

							<?php foreach ($this->data['especial'] as $category) : ?>
								<div class="mp-item">
									<?php echo (new View('category/card', $category))->get() ?>
								</div>

							<?php endforeach ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($this->data['balcao']) && !empty($this->data['balcao'])) : ?>
			<div class="mp-tab-content" id="mp-tab-balcao">
				<div class="mp-tab-header">
					<span><?= $data['balcao'] ?></span>
				</div>
				<div class="mp-tab-body">
					<div class="mp-row">
						<div class="mp-listing">

							<?php foreach ($this->data['balcao'] as $category) : ?>
								<div class="mp-item">
									<?php echo (new View('category/card', $category))->get() ?>
								</div>

							<?php endforeach ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php if (is_balcony()) : ?>
			<div class="mp-tab-content" id="mp-tab-art-creation">
				<div class="mp-tab-header">
					<span><?= $data['art_creation'] ?></span>
				</div>
				<div class="mp-tab-body">
					<?= new View('component', 'mp_balcony_art_creation') ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
<script type="text/javascript">
	jQuery('.remover_favorito').click(function() {
		var defaultStoreUrl = "<?= rtrim( esc_url( config('plugin', 'url_loja', home_url('/') ) ), '/' ) ?>";
		var base_url = (window.MrPrint && window.MrPrint.storeUrl)
			? window.MrPrint.storeUrl
			: defaultStoreUrl || ("https://" + window.location.hostname);

		jQuery('#salvar_favorito').attr('disabled', "true");
		jQuery('.loader').css('display', "block");
		var params = jQuery(this).attr('fav-id');
		console.log(params);
		var url = base_url + '/wp-admin/admin-ajax.php?action=mp_remove_favorite&id=' + params;
		fetch(url).then(function(response) {
			jQuery('.loader').css('display', "none");
			if (response) {
				alert('Item removido dos seus favoritos');
				window.location.reload();
			} else {
				alert("Erro ao remover o item dos favoritos");
			}
		});
	});
</script>
<style type="text/css">
	div[data-component="vc_mp_categories_featured"] .mp-card .mp-card-caption .mp-card-title {
		margin-bottom: <?php echo $data['card_title_margin_size_px'] . 'px !important'; ?>;
		width: 100%;
		text-overflow: ellipsis;
		overflow: hidden;
	}

	div[data-component="vc_mp_categories_featured"] .mp-card .mp-card-caption .mp-card-description {
		margin-bottom: <?php echo $data['card_description_margin_size_px'] . 'px !important'; ?>;
	}

	div[data-component="vc_mp_categories_featured"] .mp-card .mp-card-caption p {
		margin-bottom: <?php echo $data['card_text_margin_size_px'] . 'px !important'; ?>;
	}

	.mp-listing:not(.owl-carousel) {
		display: flex;
		flex-flow: row wrap;
		justify-content: center;
	}

	.mp-listing:not(.owl-carousel) .mp-item {
		display: block;
		float: left;
		max-width: 280px;
		clear: none;
		height: 100%;
		max-height: 550px;
	}

	@media (max-width:970px) {
		.mp-listing:not(.owl-carousel) .mp-item {
			max-height: 590px;
		}
	}

	@media (max-width:770px) {
		.mp-listing:not(.owl-carousel) .mp-item {
			max-height: 550px;
		}
	}
	}
</style>