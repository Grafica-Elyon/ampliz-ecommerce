<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Cliente;
use Carbon\Carbon;
use MisterPrint\BO\Carrinho;
use MisterPrint\BO\Frete;
use MisterPrint\BO\Pedido;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\SessionSupport;
use MisterPrint\Support\View;

class CheckoutShipping extends CheckoutComponent
{
	protected $name = 'Checkout Frete';
	protected $description = 'Componente para a primeira fase do checkout, onde sera selecionado o shipping.';
	protected $base = 'vc_mp_checkout_shipping';

	public function render(){
		$correio = null;
		$frete = new Frete();
		$cliente = new Cliente();
		$user_id = user()->getId();
		$cep = self::getUserCEP();
		$address = $cliente->get_endereco_entrega_do_cliente($user_id);
		$client = $cliente->get_dados_do_cliente($user_id);
		$endereco = $cliente->get_endereco_entrega_selecionado($user_id);
		$pedido = (new Pedido)->revisao_do_pedido(user()->getId());
		$data = [
			'shipping_code' => $client['dadosCliente']['customers_regiao'] ?? '',
			'shipping_type' => 'withdraw',
			'balcony_cep' => $cep
		];

		if(!empty($data['shipping_code'])){ //setando se o frete escolhido anteriormente está em alguma remessa
			$correio = $frete->get_opcoes_fretes($user_id);
			if($data['shipping_code'] == 'PAC' || $data['shipping_code'] == 'SXC') {
				$data['shipping_type'] = 'shipping';
				$data['shipping'] = 'correio';
			}
		}
		//$me = $frete->get_opcoes_menv($user_id);
		$data = array_merge($data, array(
			'errors' => $_POST['errors'],
			'data' => $data,
			'cliente' => $client,
			'endereco_id' => isset($endereco['id']) ? $endereco['id'] : null,
			
			'correio' => $correio,
			
			'address' => $address,
			'user_cep' => $cep,
			
			'sidebar' => self::getSidebar(),
			'params' => $this->getParamsAjax()
		));
		// caso não esteja atualizado redireciona pro recadastro
		if($client['dadosCliente']['customers_recadastro'] == 0){
			$data['redirect'] = true;
		}
		return (new View('checkout/checkout-shipping', $data))->get();
	}


	public static function shipping_price()
	{
		return function () {
			$data = $_POST['data'];
			$params = json_decode(base64_decode($_POST['params']), true);
			$user_id = user()->getId();
			$address = (new Cliente())->get_endereco_entrega_do_cliente($user_id);
			$frete = new Frete();
			$frete->definir_endereco_entrega($user_id, $data['address']);
			$data['remessa_direta_ativa'] = $frete->remessaDiretaAtiva();
			$me = $frete->get_opcoes_menv($user_id);
			$cep = '';

			foreach($address as $item) {
				if($data['address'] == $item['id']) {
					$cep = $item['cep'];
					break;
				}
			}
			return (new View('checkout/checkout-shipping', [
				'data' => $data,
				'balcony' => [],
				'melhor_envio' => $me,
				'correio' => $frete->get_opcoes_fretes($user_id),
				'transportadora' => $frete->get_opcoes_transportadoras($user_id),
				'motoboy' => $frete->get_opcoes_motoboy($user_id),
				'remessa' => $frete->get_opcoes_remessa_direta($user_id, $cep),
				'astrolog' => $frete->get_opcoes_astrolog($user_id),
				'address' => $address,
				'user_cep' => self::getUserCEP(),
				'sidebar' => self::getSidebar(),
				'params' => $params,
			]))->get();
		};
	}

	public static function balconies() //procura por balcão
	{
		return function () {
			$frete = new Frete();
			$data = $_POST['data'];
			$data['remessa_direta_ativa'] = $frete->remessaDiretaAtiva();
			$params = json_decode(base64_decode($_POST['params']), true);
			$user_id = user()->getId();
			$address = (new Cliente())->get_endereco_entrega_do_cliente($user_id);

			if ( $data['tipo-procura-balcao'] == 'cidade' ) {//por cidade / estado
				$balconies_nearby = [];
				$balconies = $frete->get_opcoes_balcoes_by_city($user_id, $data['balcony_state'], $data['balcony_city']);
				$balconies = array_map(function($item) {
					return [
						'codigo' => $item['id'],
						'titulo' => $item['titulo'],
						'detalhe' => $item['endereco'],
						'valor' => $item['valor'],
						'prazo' => $item['prazo'],
						'dataPrevisao' => $item['dataPrevisao'],
						'latitude' => '',
						'longitude' => '',
					];
				}, $balconies);
			} else if ( $data['tipo-procura-balcao'] == 'cep' ) { //por CEP
				$prazos = (new Pedido)->revisao_do_pedido(user()->getId())['valores']['prazoProdutos'];
				$balconies = $frete->get_opcoes_balcoes($user_id, $data['balcony_cep'], $prazos);
				$balconies_nearby = isset($balconies['maisProximo']) ? [$balconies['maisProximo']] : [];
				$balconies = $balconies['todos'];
			} else if ( $data['tipo-procura-balcao'] == 'cod' ) { //por código de balcão
				$balconies = $frete->get_balcao($user_id, $data['balcony_cod']);
			}else{
				$balconies = $frete->get_opcoes_balcoes($user_id, self::getUserCEP());
				$balconies_nearby = isset($balconies['maisProximo']) ? [$balconies['maisProximo']] : [];
				$balconies = $balconies['todos'];
			}

			return [
				'html' => (new View('checkout/checkout-shipping', [
					'data' => $data,
					'balconies' => $balconies,
					'balconies_nearby' => $balconies_nearby,
					'correio' => [],
					'transportadora' => [],
					'motoboy' => [],
					'remessa' => [],
					'astrolog' => [],
					'address' => $address,
					'user_cep' => self::getUserCEP(),
					'sidebar' => self::getSidebar(),
					'params' => $params,
				]))->get()
			];
		};
	}

	public static function remessas()
	{
		return function () {
			$frete = new Frete();
			$data = $_POST['data'];
			$data['past'] = $_POST['data'];
			$data['direct_value'] = $data['direct_value'];
			$data['direct_document'] = $data['direct_document'];
			$data['direct_document_type'] = $data['direct_document_type'];
			$data['remessa_direta_ativa'] = $frete->remessaDiretaAtiva();
			$errors = [];
			$params = json_decode(base64_decode($_POST['params']), true);
			$cliente = new Cliente();
			$address = $cliente->get_endereco_entrega_do_cliente(user()->getId());
			$endereco = $cliente->auto_completar_endereco(['cep' => $data['direct_cep']]);
			$remessas = $frete->get_opcoes_remessa_direta(user()->getId(), $data['direct_cep']);

			if ( isset($endereco['erro']) ) {
				$errors[] = 'Não foi possível encontrar o CEP para envio.';
			}if ( empty($remessas) ) {
				$errors[] = 'Não há remessa direta para este CEP.';
			}
			if(is_array($endereco) && !isset($endereco['erro'])) {
				$data['direct_cep'] = $endereco['cep'];
				$data['direct_endereco'] = $endereco['logradouro'];
				$data['direct_numero'] = $endereco[''];
				$data['direct_complemento'] = $endereco[''];
				$data['direct_bairro'] = $endereco['bairro'];
				$data['direct_cidade'] = $endereco['localidade'];
				$data['direct_uf'] = $endereco['uf'];
			}else {
				$data['direct_cep'] = '';
				$data['direct_endereco'] = '';
				$data['direct_numero'] = '';
				$data['direct_complemento'] = '';
				$data['direct_bairro'] = '';
				$data['direct_cidade'] = '';
				$data['direct_uf'] = '';
			}
			return [
				'html' => (new View('checkout/checkout-shipping', [
					'data' => $data,
					'errors' => $errors,
					'balconies' => [],
					'balconies_nearby' => [],
					'correio' => [],
					'transportadora' => [],
					'motoboy' => [],
					'astrolog' => [],
					'remessa' => $remessas,
					'address' => $address,
					'user_cep' => self::getUserCEP(),
					'sidebar' => self::getSidebar(),
					'params' => $params,
				]))->get()
			];
		};
	}

	static public function action()
	{
		return function () {
			$frete = false;
			$data = $_POST['data'];
			if('direct' == $data['shipping_type']) {
				$address = [
					'nome' => $data['direct_name'],
					'valor' => $data['direct_value'],
					'documento' => $data['direct_document'],
					'documento_tipo' => $data['direct_document_type'],
					'endereco' => $data['direct_endereco'],
					'numero' => $data['direct_numero'],
					'complemento' => $data['direct_complemento'],
					'bairro' => $data['direct_bairro'],
					'cep' => $data['direct_cep'],
					'cidade' => $data['direct_cidade'],
					'estado' => $data['direct_uf']
				];

				$frete = (new Frete())->adicionar_endereco_remessa_direta(user()->getId(), $address, $data['shipping_code']);

				if(isset($frete['id'])) {
					(new SessionSupport())::set('checkout-shipping', [
						'address' => $address,
						'remessa' => $frete['id'],
						'shipping' => isset($data['shipping_data_'.$data['shipping_code']]) ? json_decode(base64_decode($data['shipping_data_'.$data['shipping_code']]), true) : null
					]);
				}else{
					$_SESSION['cart_error'] = "Erro ao salvar endereço de remessa direta";
					$frete = false;
				}
			} else {
				$frete = (new Frete())->definir_opcao_de_frete(user()->getId(), $data['shipping_code']);

				(new SessionSupport())::set('checkout-shipping', [
					'address' => isset($data['address']) ? $data['address'] : null,
					'remessa' => false,
					'shipping' => isset($data['shipping_data_'.$data['shipping_code']]) ? json_decode(base64_decode($data['shipping_data_'.$data['shipping_code']]), true) : null
				]);
			}

			if($frete) {
				return [ 'redirect' => get_page_url('checkout_billing') ];
			}

			$_POST['errors'] = "Não foi possivel cadastrar o endereço de entrega. Por favor, verifique os dados";
			return [ 'redirect' => get_page_url('checkout_shipping') ];
		};
	}

	public static function cache_freight()
	{
		return function () {
			$freight['price'] = $_POST['data']['freight_price'];
			set_transient('freight_' . user()->getId(), $freight, HOUR_IN_SECONDS);
			return $freight;
		};
	}

	public static function getUserCEP()
	{
		$address = user()->getAddress();

		if(isset($address['cep'])) {
			return $address['cep'];
		}

		return '';
	}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo painel', 'Frete'),
			Vc::paramText('Subtitulo balcao', 'Encontre o balcao de retirada mais próximo de você'),
			Vc::paramText('Subtitulo painel', 'Vamos calcular o frete'),
			Vc::paramText('Entrega ou balcão', 'Você quer receber em casa ou retirar no balcão'),
			Vc::paramText('Titulo calculo de frete', 'Selecione uma opção para o cálculo do frete'),
			Vc::paramText('Texto tooltip', 'Tamanho de um dos itens acima do maximo do frete'),
			Vc::paramText('Formas de envio', 'Formas de envio'),
			Vc::paramText('Endereço de entrega', 'Endereço de Entrega'),
			Vc::paramText('Botão voltar', 'Voltar'),
			Vc::paramText('Botão avançar', 'Avançar'),
		]);
	}
}
