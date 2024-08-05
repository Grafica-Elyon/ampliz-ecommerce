<?php use MisterPrint\Support\View;
$data = $this->data['params'];
?>

<input type="hidden" name="params" value="<?= base64_encode(json_encode($data)) ?>" />
<div class="mp-heading">
	<div class="mp-heading-line">
		<h2 class="mp-head"><?= $data['titulo'] ?></h2>
	</div>
	<p><?= $data['subtitulo']?></p>
</div>
<br /><br />
<?php if(!empty($this->data['special_products'])) { ?>
	<div class="mp-row">
		<div class="mp-listing">
			<?php foreach ($this->data['special_products'] as $category) : ?>
				<div class="mp-item">
					<?php echo (new View('category/card', $category))->get() ?>
				</div>

			<?php endforeach ?>
		</div>
	</div>
	<hr style="margin: 0 0 50px;">
<?php } ?>
<div class="mp-row">
	<div class="mp-listing">
		<?php foreach ($this->data['categories'] as $category) : ?>
			<div class="mp-item">
				<?php echo (new View('category/card', $category))->get() ?>
			</div>
		<?php endforeach ?>
	</div>
</div>

<?php if ( false == ( $this->data['pagination']['current'] == 1 && $this->data['pagination']['total'] == 1 ) ): ?>
	<?php echo (new View('category/pagination', ['pagination' => $this->data['pagination']]))->get() ?>
<?php endif; ?>

<style type="text/css">
	div[data-component="vc_mp_categories"] .mp-card .mp-card-caption .mp-card-title {
	    margin-bottom: <?php echo $data['card_title_margin_size_px'].'px !important'; ?>;
	}
	div[data-component="vc_mp_categories"] .mp-card .mp-card-caption .mp-card-description {
	    margin-bottom: <?php echo $data['card_description_margin_size_px'].'px !important'; ?>;
	}
	div[data-component="vc_mp_categories"] .mp-card .mp-card-caption p {
	    margin-bottom: <?php echo $data['card_text_margin_size_px'].'px !important'; ?>;
	}
	.mp-listing:not(.owl-carousel){
		display: flex;
	    flex-flow: row wrap;
	    justify-content: center;
	}

	.mp-listing:not(.owl-carousel) .mp-item{
	    display: block;
	    float: left;
	    max-width: 280px;
	    clear: none;
	    height: 100%;
	    max-height: 530px;
	}
	@media (max-width:970px){
		.mp-listing:not(.owl-carousel) .mp-item{
		    max-height: 540px;
		}
		.mp-card .mp-card-caption p {
		    font-size: 1.2rem;
		}
	}
	@media (max-width:770px){
		.mp-listing:not(.owl-carousel) .mp-item{
		    max-height: 500px;
		}
		.mp-card .mp-card-caption p {
		    font-size: 1.4rem;
		}
	}

</style>