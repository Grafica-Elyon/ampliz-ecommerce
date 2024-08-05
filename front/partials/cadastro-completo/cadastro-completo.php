<?php
ob_start();
/**
 * Shortcode attributes
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */

?>
<?php
$atts = shortcode_atts(
	[
		'cadastro_completo_submit_value'      => 'Enviar',
	],
	$atts
);
?>
	<div class="cadastro <?= $atts['cadastro_completo_class']; ?>">

		<h2><?=get_the_title();?></h2>

		<form method="post" id="cadastro-completo">
			<?= wpb_js_remove_wpautop($content); ?>
			<p style="margin-top: 20px;">
				<input type="submit" value="<?= $atts['cadastro_completo_submit_value']; ?>" id="cadastro-completo-enviar" class="btn btn-secondary" />
			</p>
		</form>
	</div>
<?php
$output = ob_get_contents();
ob_end_clean();

echo $output;
