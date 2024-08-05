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
$SessionSupport = new MisterPrint\Support\SessionSupport();
if (empty($SessionSupport->userId)) {
$atts = shortcode_atts(
	[
			'client_authentication_title'           => 'Login',
			'client_authentication_submit_value'    => 'Enviar'
	],
	$atts
);
?>
	<div class="autenticacao <?=$atts['client_authentication_class'];?>">
		<h2><?= $atts['client_authentication_title']; ?></h2>
		<form method="post" id="autenticacao">
			<?= wpb_js_remove_wpautop($content); ?>
			<input type="submit" value="<?= $atts['client_authentication_submit_value']; ?>" id="client-authentication-submit" class="btn btn-secondary" />
		</form>
		<br><hr><br>
		<h2>Cadastre-se</h2>
		<p>Ainda não tem cadastro? Clique <a href="<?php echo site_url('cadastro-completo')?>">aqui</a> para cadastrar-se.</p>
	</div>

<?php
$output = ob_get_contents();
ob_end_clean();

echo $output;

}else{
	wp_redirect(MisterPrint\Helper\Url::getShopUrl());
}
