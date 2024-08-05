<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Carrinho;
use MisterPrint\BO\Cliente;
use MisterPrint\BO\Empresa;
use MisterPrint\BO\Pagamento;
use MisterPrint\BO\Pedido;
use MisterPrint\Factory\Vc;
use MisterPrint\Admin\Includes\Log;
use MisterPrint\Response\PagseguroGetToken;
use MisterPrint\Support\SessionSupport;
use MisterPrint\Support\View;

class CheckoutBilling extends CheckoutComponent
{
	protected $name = 'Checkout Cobrança';
	protected $description = 'Componente para a última fase do checkout, onde sera efetuada a cobrança.';
	protected $base = 'vc_mp_checkout_billing';

	function render(){
		$session = (new SessionSupport());
		$payments = (new Pagamento())->get_formas_de_pagamento(user()->getId());
		$shipping = $session::get('checkout-shipping');
		$confirmation = $session::get('checkout-confirmation');
		$credit = (new Cliente())->get_saldo(user()->getId());
		$credit = isset($credit['Saldo']) ? $credit['Saldo'] : 0;
		$user = user()->getData();
		$order = new Pedido();
		$itens_carrinho = user()->hasProductInCart();

		if(!$itens_carrinho && user()->getId() != null){
			$last = array();
			$last['status'] = "success";
			$last['codigoPedido'] = $order->get_last_order(user()->getId());
			if($last['codigoPedido'] == null){//se o cliente nunca fechou compra...
				if(wp_redirect('/')) { exit; }
			}
			(new SessionSupport())::set('last-registered-order', $last);
			return (new View('checkout/checkout-complete', [
				'checkoutNumber' => $last['codigoPedido'],
				'pedido' => $last,
				'detalhes' => (new Pedido)->get_detalhes_do_pedido($last['codigoPedido']),
				'params' => [
					'titulo' => 'Finalizar compra',
					'subtitulo' => 'Seu pedido foi feito com sucesso!',
					'passo_1' => 'Frete',
					'passo_2' => 'Confirmação de <br>compra',
					'passo_3' => 'Dados de cobrança <br> e Pagamento',
					'titulo_2' => 'A sua compra foi confirmada.',
					'numero_pedido' => 'Número do pedido:',
					'botao_enviar_arte' => 'Enviar arte',
					'continuar_comprando' => 'Continuar comprando',
					'acompanhar_pedido' => 'Acompanhar pedido',
					]
			]))->get();
		}

		$errors = array();
		$is_valid = json_decode($order->validar_pedido(user()->getId(), false), true);
		if($is_valid['error']){
			$errors[] = $is_valid['error'];
			$payments = false;
			if(isset($is_valid['cart_error'])){
				$cart = get_page_url('cart');
				$_SESSION['cart_error'] = $is_valid['error'];
				return "<script>window.location.href = '{$cart}'</script>";
			}
		}

		if($session::exists('billing-errors')) {
			$errors[] = $session::get('billing-errors');
			$session::delete('billing-errors');
		}

		if($payments['error']) {
			$errors[] = $payments['error'];
			$payments = false;
		}

		$sidebar = $this->getSidebar();
		$cupom = ['name' => ''];

		if ( $sidebar['cupom'] ) {
			$cupom = [
				'success' => true,
				'name' =>  $sidebar['cupom']['cod'],
				'value' =>  money($sidebar['cupom']['valor']),
			];
		}

		return (new View('checkout/checkout-billing', [
			'payments' => $payments,
			'address' => $this->getAddress($shipping['address']),
			'checkout-confirmation' => $confirmation,
			'sidebar' => $sidebar,
			'user' => $user,
			'token' => self::setSessionToken(),
			'banks' => (new Empresa())->get_dados_bancarios(),
			'params' => $this->getParamsAjax(),
			'credit' => $credit,
			'errors' => $errors,
			'coupon' => $cupom
		]))->get();
	}

	public static function setSessionToken(){
		global $wpdb;
        $table = $wpdb->prefix.'customers';
        $usuario = user()->getId();
        $res = $wpdb->get_results("SELECT * FROM $table WHERE customers_id = '{$usuario}'");
        if(count($res) > 0){//se tem usuario no BD
        	$atual = $res[0]->token + 1;
        	$query = $wpdb->query("UPDATE {$table} SET token = {$atual} WHERE customers_id = '{$usuario}'");
        	if($query){
        		return $atual;
        	}
        	return false;
        }else{
        	$query = $wpdb->query("INSERT INTO {$table} (customers_id, token) VALUES ({$usuario},1)");
        	if($query){ return 1; }
        }
        return false;
	}

	public function getAddress($address_id)
	{
		$addresses = (new Cliente())->get_endereco_entrega_do_cliente(user()->getId());

		foreach ($addresses as $address) {
			if ($address_id == $address['id']) {
				return $address;
			}
		}
		return false;
	}

	public function makeCreditCardPayment($data) {

		$valid = explode('/', $data['card-valid']);

		$data = [
			'credito' => isset($data['credito']) && $data['credito'] == 'utilizar',
			'installment' => $data['card-parcelas'] ?: 1,
			'card-number' => $data['card-number'],
			'card-code' => $data['card-code'],
			'card-valid' => [
				'month' => $valid[0],
				'year' => $valid[1],
			],
			'card-name' => $data['card-name']
		];

		$payment = (new Pagamento())->registrar_pagamento(user()->getId(), $data);

		return $payment;
	}

	public function makeTransferPayment($comprovante) {

		$pedido = (new Pedido)->revisao_do_pedido(user()->getId());
		$client = (new Cliente())->get_dados_do_cliente(user()->getId());

		$data = [
			'portador' => $client['dadosCliente']['customers_firstname'],
			'total' => $pedido['valores']['total'],
			'comprovante' => $comprovante,
		];

		$payment = (new Pagamento())->registrar_transferencia(user()->getId(), $data);

		if(isset($payment['response']) && 'error' == $payment['response']) {
			return [
				'error' => $payment['transaction-response']
			];
		}

		return $payment;
	}

	public function makeSinalPayment( $total, $comprovante = '', $credito = false, $parcelas = 1) {

		$data = [
			'parcelas' => $parcelas,
			'total' => $total,
			'comprovante' => $comprovante,
			'credito' => $credito,
		];

		$payment = (new Pagamento())->registrar_sinal(user()->getId(), $data);

		return $payment;
	}

	public function makeWithdrawalPayment() {
		return (new Pagamento())->registrar_pagamento_retirada(user()->getId());
	}

	public function useCoupon( $cod )
	{
		return (new Pagamento())->usar_cupom(user()->getId(), $cod);
	}

	public function registerOrder($payment, $credit = false, $nota = '') {
		$order = new Pedido();

		$checkout_shipping = SessionSupport::get('checkout-shipping');

		$remessa = null;
		if( $checkout_shipping['remessa']) {
			$remessa =  $checkout_shipping['remessa'];
		}

		return $order->registrar_pedido(user()->getId(), $payment, $remessa, $credit, $nota);
	}

	static public function action() {
		return function() {
			$order = new Pedido();
			$data = $_POST;
			$checkout = new self();
			$payment = null;
			$errors = [];
			$_SESSION['pf_pj'] = stripos($data['pessoa'],'f') !== false ? "cpf" : "cnpj"; 

			//verifica se os dados do pedido estão ok antes do pagamento
			$credit = ($data['credito'] == 'utilizar') ? true : false;

			/*$is_valid = json_decode($order->validar_pedido(user()->getId(), $credit), true);
			if($is_valid['error']){
				$errors[] = $is_valid['error'];
			}*/

			if ( $data['coupon'] ) {

				$printData = $checkout->useCoupon( $data['coupon'] );

				if ( $printData['valid'] == false ) {
					(new SessionSupport())::set('billing-errors', [
						isset($printData['errorMessage']) && $printData['errorMessage'] ?
							$printData['errorMessage']:
							"Não foi possível utilizar o cupom"
					]);

					if(wp_redirect(get_page_url('checkout_billing'))) {
						exit;
					}
				}
			}

			if($data['payment'] == 'getnet-iframe'){
				$payment = $order->get_getnet_payment_id(user()->getId());
				if($payment['error']){
					$errors[] = $payment['error'];
				}else{
					$payment['codigoPagamento'] = $payment['id'];
				}
			}

			if($data['payment'] == 'cartao-de-credito') {
				$payment = $checkout->makeCreditCardPayment($data);

				if(isset($payment['response']) && $payment['response'] == 'error') {
					$errors[] = $payment['message'];
				}

				if(!isset($payment['codigoPagamento']) && empty($errors)) {
					$errors[] = 'Erro ao processar seu pagamento, verifique os dados do cartão.';
				}
			}

			if( $data['payment'] == 'pix-deposito-transferencia' ){
				$payment_errors = self::validateComprovante($_FILES['comprovante']);

				if(!empty($payment_errors)) {
					$errors = array_merge($errors, $payment_errors);
					$payment = false;
				}
				else {
					$payment = $checkout->makeTransferPayment($_FILES['comprovante']);
				}
			}

			if($data['payment'] == 'sinal') {
				if(!isset($data['sinal'])) {
					$errors[] = 'Dados não inseridos corretamente';
					$payment = false;
				}
				else if ( !$data['sinal']['comprovante'] && $data['sinal']['forma'] != 'dinheiro' ) {
					$errors[] = 'Comprovante não inserido';
					$payment = false;
				}
				else {
					$data['sinal']['valor'] = str_replace('.', '', $data['sinal']['valor']);
					$data['sinal']['valor'] = str_replace(',', '.', $data['sinal']['valor']);

					if ( $data['sinal']['forma'] == 'dinheiro' ) {
						$data['sinal']['comprovante'] = 'dinheiro_'.date( 'Y-m-d_h:i:s' );
					}

					$payment = $checkout->makeSinalPayment( $data['sinal']['valor'], $data['sinal']['comprovante'], $data['credito'] == 'utilizar', $data['sinal']['parcelas'] );

					if( isset($payment['response']) && $payment['response'] == 'error' ) {
						$errors[] = $payment['transaction-response'] ?: $payment['message'];
					}
					else if(!isset($payment['codigoPagamento'])) {
						$errors[] = 'Erro ao processar o sinal';
					}
				}
			}

			if($data['payment'] == 'pagar-na-retirada') {
				$payment = $checkout->makeWithdrawalPayment();

				if(isset($payment['error'])) {
					$errors[] = $payment['message'] ?: $payment['error'];
				}

				if(!isset($payment['codigoPagamento'])) {
					$errors[] = 'Erro ao processar sua solicitação, verifique se esse método ainda está disponível para você.';
				}
			}

			if($data['payment'] == 'pagseguro') {

				$result = PagseguroGetToken::get( ['credito' => $data['credito'] == 'utilizar'] );

				// Caso tenha dado falha, muda o resultado para dar o erro padrão
				if ( !$result ) {
					$result = [
						'response' => false,
						'message' => false,
					];
				}

				// Se foi tudo certo, tenta redirecionar
				if ( $result['response'] == 'success' ) {
					if (wp_redirect( $result['message'] )) {
						exit();
					}
					// Se não foi possível redirecionar, ele limpa a url
					unset($result['message']);
				}

				// Se não deu para redirecionar ou deu erro na requisição
				$errors[] = @$result['message'] ?: 'Não foi possível registrar compra no PagSeguro';
			}

			if($data['payment'] == 'PagSeguroContinuacao') {
				$payment = ['codigoPagamento' => $data['codigo']];
			}


			if(is_null($payment) && $data['credito'] != 'utilizar' && !( $data['payment'] == '' && $data['coupon'] )) {
				$errors[] = 'Selecione a forma de pagamento.';
			}

			$order = [];
			if(empty($errors)) {
				$credit = ($data['credito'] == 'utilizar') ? true : false;
				$order = $checkout->registerOrder($payment['codigoPagamento'], $credit, $_SESSION['pf_pj']);
				if(isset($order['codigoPedido'])) {
					$order['payment'] = $payment;
					$order['payment_code'] = $data['payment'];
					(new SessionSupport())::set('last-registered-order', $order);
				}

				if(isset($order['error'])) {
					$errors[] = $order['error'];
				}
				if(empty($errors)) {
					user()->clearCart();
					if(wp_redirect(get_page_url('checkout_complete'))) {
						exit;
					}
				}
			}

			(new SessionSupport())::set('billing-errors', $errors);

			if(wp_redirect(get_page_url('checkout_billing'))) {
				exit;
			}
		};
	}

	public static function validateComprovante($comprovante)
	{
		$errors = []; // Store all foreseen and unforseen errors here

		$extensions = ['jpeg','jpg','png','pdf']; // Get all the file extensions

		$name = $comprovante['name'];
		$size = $comprovante['size'];
		$tmp_name  = $comprovante['tmp_name'];
		$type = $comprovante['type'];
		$fileinfo = pathinfo($name);

		if (! in_array($fileinfo['extension'],$extensions)) {
			$errors[] = "Extensão do arquivo inválida, por favor o comprovante deve ser: png ou jpg";
		}

		if ($size > 2000000) {
			$errors[] = "O tamanho do arquivo esta superior ao permitido.";
		}

		return $errors;
	}

	public static function coupon()
	{
		return function() {
			$coupon_return = (new Carrinho())->aplicar_cupom_de_desconto(user()->getId(), $_POST['data']['coupon']);

			$sidebar = (new CheckoutComponent)->getSidebar();

			$coupon = [
				'name' => $_POST['data']['coupon'],
				'value' => ($coupon_return['tipoDesconto'] == 'porcentagem') ? intval($coupon_return['valorCupom']).'%' : money($coupon_return['valorCupom']),
				'success' => ($coupon_return['status'] == 'success') ? true : false,
			];

			return array_merge($coupon, [
				'status' => $coupon_return['status'],
				'sidebar' => (new View('checkout/sidebar', $sidebar))->get(),
				'coupon' => (new View('checkout/checkout-billing-cupom', ['coupon' => $coupon]))->get()
			]);
		};
	}

	public static function continueGetnet()
	{
		return function () {return 0;};
	}

	public static function continuePagseguro()
	{
		return function () {

			if ( !user()->getId() ) {
				$redirectTo = "/wp-admin/admin-ajax.php?".$_SERVER['QUERY_STRING'];
				if( wp_redirect( get_page_url('login').'?redirectTo='.urlencode($redirectTo) ) ) {
					exit;
				}
			}

			$showErrors = function ( $errors = null ) {
				if ( !$errors ) {
					$errors = ['Não foi possível concluir o seu pagamento. Entre em contato com nosso setor comercial'];
				}

				(new SessionSupport())::set('billing-errors', $errors);

				if(wp_redirect(get_page_url('checkout_billing'))) {
					exit;
				}
			};

			if ( !$_GET['transaction_id'] ) {
				$showErrors([
					'Não foi encontrado código de autenticação do pagamento'
				]);
			}

			$validacao = \MisterPrint\Response\PagseguroValidateToken::get( $_GET['transaction_id'] );

			if ( !$validacao ) {
				$showErrors([
					'Código de autenticação não é válido'
				]);
			}
			else if ( @$validacao['response'] == 'error' ) {
				$showErrors([
					$validacao['message']
				]);
			}
			else {
				$_POST['payment'] = 'PagSeguroContinuacao';
				$_POST['codigo'] = $validacao['codigoPagamento'];
				$_POST['credito'] = $validacao['credito'];
				return self::action()();
			}
		};
	}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo painel dados', 'Confirmação de compra'),
			Vc::paramText('Subtitulo painel dados', 'As informações do seu pedido estão corretas?'),
			Vc::paramText('Painel dados nome', 'Nome'),
			Vc::paramText('Painel dados endereço', 'Endereço'),
			Vc::paramText('Painel dados telefone', 'Telefone'),
			Vc::paramText('Painel dados nota fiscal', 'Emissão de Nota Fiscal'),
			Vc::paramText('Titulo painel desconto', 'Cupom de Desconto e Crédito em Conta Corrente'),
			Vc::paramText('Subtitulo painel desconto', 'Caso possua cupom de desconto ou crédito em conta corrente interna, informe abaixo'),
			Vc::paramText('Painel desconto possui cupom', 'Possui cupom de desconto?'),
			Vc::paramText('Painel desconto cupom placeholder', 'Digite o número do cupom'),
			Vc::paramText('Painel desconto usar credito', 'Utilizar crédito em conta corrente?'),
			Vc::paramText('Painel desconto usar credito info', 'Mais informações'),
			Vc::paramText('Painel desconto usar credito tooltip', 'Texto que ajuda muito'),
			Vc::paramText('Painel desconto valor conta', 'Valor atual em conta:'),
			Vc::paramText('Painel desconto usar crédito', 'Utilizar Crédito'),
			Vc::paramText('Painel desconto não usar crédito', 'Não utilizar crédito'),
			Vc::paramText('Titulo painel pagamento', 'Forma de pagamento'),
			Vc::paramText('Subtitulo painel pagamento', 'Escolha a melhor opção para confirmar sua compra.'),
			Vc::paramText('Painel pagamento cartão bandeira', 'Bandeira'),
			Vc::paramText('Painel pagamento cartão bandeira select', 'Selecione a bandeira'),
			Vc::paramText('Painel pagamento cartão nome', 'Nome impresso'),
			Vc::paramText('Painel pagamento cartão nome placeholder', 'Digite aqui o nome impresso no cartão'),
			Vc::paramText('Painel pagamento cartão numero', 'Número do cartão'),
			Vc::paramText('Painel pagamento cartão numero placeholder', 'Digite o número do cartão'),
			Vc::paramText('Painel pagamento cartão vencimento', 'Vencimento'),
			Vc::paramText('Painel pagamento cartão vencimento placeholder', 'Digite a data de vencimento do cartão'),
			Vc::paramText('Painel pagamento cartão CVV', 'CVV'),
			Vc::paramText('Painel pagamento cartão CVV placeholder', 'Digite o código de verificação do cartão'),
			Vc::paramText('Painel pagamento cartão Parcelas', 'Parcelas'),
			Vc::paramText('Painel pagamento cartão Parcelas 1', '%qtde%x sem juros ( R$ %valor% )'),
			Vc::paramText('Painel pagamento cartão Parcelas Outros', '%qtde%x sem juros ( R$ %valor% )'),
			Vc::paramText('Painel pagamento Banco', 'Banco'),
			Vc::paramText('Painel pagamento conta', 'Conta'),
			Vc::paramText('Painel pagamento Agencia', 'Agência'),
			Vc::paramText('Painel pagamento CNPJ', 'CNPJ'),
			Vc::paramText('Painel pagamento titular', 'Titular'),
			Vc::paramText('Botão voltar', 'Voltar'),
			Vc::paramText('Botão avançar', 'Avançar'),
			Vc::paramSidebarPosition('Posição da sidebar', 'right'),
		]);
	}
}
