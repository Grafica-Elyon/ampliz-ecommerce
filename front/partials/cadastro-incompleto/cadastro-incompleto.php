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
			'cadastro_incompleto_submit_value'      => 'Enviar',
		],
		$atts
	);
?>

<div class="cadastro <?=$atts['cadastro_incompleto_class'];?>"">

	<h2><?=get_the_title();?></h2>

	<form method="post" id="cadastro-incompleto">
		<?= wpb_js_remove_wpautop($content); ?>
		<p style="margin-top: 20px;">
			<input type="submit" value="<?= $atts['cadastro_incompleto_submit_value']; ?>" id="cadastro-incompleto-enviar" class="btn btn-secondary" />
		</p>
	</form>
</div>
<?php
$output = ob_get_contents();
ob_end_clean();

echo $output;
