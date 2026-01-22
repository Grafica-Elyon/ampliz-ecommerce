<style>
	<?php
	function adjustBrightness($hexCode, $adjustPercent)
	{
		$hexCode = ltrim($hexCode, '#');

		if (strlen($hexCode) == 3) {
			$hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
		}

		$hexCode = array_map('hexdec', str_split($hexCode, 2));

		foreach ($hexCode as &$color) {
			$adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
			$adjustAmount = ceil($adjustableLimit * $adjustPercent);

			$color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
		}

		return '#' . implode($hexCode);
	}
	function darken_color($rgb, $darker = 2)
	{
		return adjustBrightness($rgb, max($darker, 1) / 100 * -1);
	}
	function lighten_color($rgb, $ligher = 2)
	{
		return adjustBrightness($rgb, max($ligher, 1) / 100);
	}
	$primary = get_option('bs_publisher_theme_options')['theme_color'];
	?>:root {
		--primary-color: <?= $primary ?>;
		--primary-color-darken-1: <?= darken_color($primary, 10) ?>;
		--primary-color-darken-2: <?= darken_color($primary, 25) ?>;
		--primary-color-darken-3: <?= darken_color($primary, 50) ?>;
		--primary-color-lighten-1: <?= lighten_color($primary, 10) ?>;
		--primary-color-lighten-2: <?= lighten_color($primary, 25) ?>;
		--primary-color-lighten-3: <?= lighten_color($primary, 50) ?>;
	}

	<?php if (user()->isLogged()) { ?>.hide-logged {
		display: none !important;
	}

	.show-logged {
		display: inline-block !important;
	}

	<?php } else { ?>.hide-logged {
		display: inline-block !important;
	}

	.show-logged {
		display: none !important;
	}

	<?php } ?><?php if (is_balcony()): ?>.hide-balcony {
		display: none !important;
	}

	.show-balcony {
		display: inline-block !important;
	}

	<?php else: ?>.hide-balcony {
		display: inline-block !important;
	}

	.show-balcony {
		display: none !important;
	}

	<?php endif; ?>
</style>
<?php
$storeUrl = rtrim(config('plugin', 'url_loja', home_url('/')), '/');
$storeUrl = $storeUrl ?: home_url('/');
$apiConfig = mp_get_api_configuration();
$apiUrl = $apiConfig['apiBase'];
$authorizationToken = $apiConfig['authorization'];
?>
<script type="text/javascript">
	window.MrPrint = {
		plugin: <?= json_encode([
					'version' => config('plugin', 'version'),
				], JSON_PRETTY_PRINT) ?>,
		storeUrl: "<?= esc_url( $storeUrl ) ?>",
		apiUrl: "<?= esc_url( $apiUrl ) ?>"
		,
		authorizationToken: "<?= esc_attr( $authorizationToken ) ?>"
	};
	<?php if (user()->isLogged()) { ?>
		window.user_login = "<?= user()->getEmail(); ?>";
	<?php } ?>
</script>
<?= new \MisterPrint\Support\View('data-layers/referer', []) ?>
<div class="mp-header">
	<div class="mp-container">
		<div class="mp-header-buttons">
			<?php
			if (has_nav_menu('mp_socket_menu')) {
				wp_nav_menu([
					'theme_location' => 'mp_socket_menu',
					'menu_class' => 'mp-socket-menu'
				]);
			}
			?>
			<div class="menu-menu-topo-container">
				<ul id="menu-menu-topo" class="mp-socket-menu">
					<li class="show-logged menu-item menu-item-type-custom menu-item-object-custom better-anim-fade menu-item-2347 bsm-leave">
						<a href="<?php echo get_page_url('my_data') ?>">
							<?php
							// Definir a saudação padrão
							$saudacao = "Entrar";

							// Verifica se o usuário está logado no sistema ou via API do Facebook
							if (isset($this->data['client']['dadosCliente']['customers_firstname'])) {
								// Usuário logado pelo sistema
								$nome = explode(" ", $this->data['client']['dadosCliente']['customers_firstname'], 2);
								$primeiro_nome = ucfirst(strtolower($nome[0]));
								$saudacao = "Olá $primeiro_nome";
							} elseif (isset($usuarioFacebook)) {
								// Usuário logado via API do Facebook
								$nomeFacebook = explode(" ", $usuarioFacebook->nome, 2);
								$primeiro_nome = ucfirst(strtolower($nomeFacebook[0]));
								$saudacao = "Olá $primeiro_nome";
							}

							// Exibir a saudação
							echo $saudacao;
							?>
						</a>
					</li>
					<li class="menu-item menu-item-type-custom menu-item-object-custom better-anim-fade menu-item-2347 bsm-leave">
						<a href="<?php echo get_page_url('cart') ?>" class="mp-btn mp-btn-primary mp-btn-square">
							<i class="icon-cart-white"></i>
							<?= $this->data['cart_count'] !== null ? '<sup>' . $this->data['cart_count'] . '</sup>'  : '' ?> Carrinho
						</a>
					</li>
				</ul>
			</div>

			<style type="text/css">
				a.mp-btn.mp-btn-primary.mp-btn-square>sup {
					background: #fff;
					height: 0.5rem;
					width: fit-content;
					color: var(--primary-color);
					border-radius: 10px;
					padding: 6px 4px;
					justify-content: center;
					border: 2px solid var(--primary-color);
					display: inline-flex;
					vertical-align: text-top;
					margin-left: -5%;
					font-size: 0.8rem;
				}
			</style>
		</div>




	</div>
</div>