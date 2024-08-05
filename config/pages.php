<?php
return [
	'categories' => [
		'name' => 'Listagem de Produtos'
	],
	'category' => [
		'name' => 'Interna de Produto'
	],
	'category_configuration' => [
		'name' => 'Configuração do produto'
	],
	'cart' => [
		'name' => 'Carrinho',
		'auth' => true
	],
	'login' => [
		'name' => 'Login'
	],
	'recovery_blocked_login' => [
		'name' => 'Recuperação de Cadastro Bloqueado',
		'validate' => function () {
			if(user()->isLogged()) {
				if(wp_redirect(get_page_url('my_data'))) {
					exit();
				}
			}
		}
	],
	'password_recovery' => [
		'name' => 'Recuperação de Senha',
		'validate' => function () {
			if(user()->isLogged()) {
				if(wp_redirect(get_page_url('my_data'))) {
					exit();
				}
			}
		}
	],
	'checkout_shipping' => [
		'name' => 'Finalizar Compra - Frete',
		'auth' => true,
		'validate' => function () {
			if(!user()->hasProductInCart()) {
				if(wp_redirect(get_page_url('categories'))) {
					exit();
				}
			}
		}
	],
	'checkout_confirmation' => [
		'name' => 'Finalizar Compra - Confirmaçao',
		'auth' => true,
		'validate' => function () {
			if(!user()->hasProductInCart()) {
				if(wp_redirect(get_page_url('categories'))) {
					exit();
				}
			}

			if(!user()->hasShipping()) {
				if(wp_redirect(get_page_url('checkout_shipping'))) {
					exit();
				}
			}
		}
	],
	'my_addresses' => [
		'name' => 'Meus Endereços',
		'auth' => true
	],
	'my_favorites' => [
		'name' => 'Meus Favoritos',
		'auth' => true
	],
	'my_orders' => [
		'name' => 'Meus Pedidos',
		'auth' => true
	],
	'my_data' => [
		'name' => 'Meus Dados',
		'auth' => true
	],
	'my_credit_extract' => [
		'name' => 'Minha Conta Corrente',
		'auth' => true
	],
	'register' => [
		'name' => 'Cadastro Completo',
		'auth' => false
	],
	'checkout_complete' => [
		'name' => 'Checkout Completo',
		'auth' => true
	],
	'checkout_billing' => [
		'name' => 'Checkout Cobrança',
		'auth' => true,
		'validate' => function () {
			if(!user()->getId()) {
				if(wp_redirect(get_page_url('login'))) {
					exit();
				}
			}
		}
	],
	'send_art' => [
		'name' => 'Envio de arte',
		'auth' => true,
		'validate' => function () {
			if(!isset($_GET['pedido']) || empty($_GET['pedido'])) {
				if(wp_redirect(get_page_url('cart'))) {
					exit();
				}
			}
		}
	],
	'creation_form' => [
		'name' => 'Formulário de criação de arte',
		'auth' => true,
		'validate' => function () {
			if(!isset($_GET['pedido']) || empty($_GET['pedido'])) {
				if(wp_redirect(get_page_url('my_orders'))) {
					exit();
				}
			}
		}
	]
];
