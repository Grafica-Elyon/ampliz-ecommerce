<?php

namespace MisterPrint\Components;

use MisterPrint\BO\User;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;
use MisterPrint\Support\SessionSupport;

class CheckoutERedeCard extends Component
{
	protected $name = 'Formulário Cartão REDE';
	protected $description = 'Formulário de pagamento por cartão REDE';
	protected $base = 'vc_mp_checkout_e_rede_card';

	function render()
	{
		$data = [];
		if (isset($_POST['data']['redirect'])) {
			$data['redirect'] = $_POST['data']['redirect'];
		}
		$data['params'] = $this->getParamsAjax();
		//error_log("Render COmponente PHP" . PHP_EOL, 3, '/home/mrprint/sandbox.mrprint.com.br/wp-content/plugins/misterprint-ecommerce/erede.log');
		//$data['params'] = 'Valdi';

		return (new View('checkout/checkout-e-rede-card', $data))->get();
	}

	public function html($atts)
	{
		$redirect = (isset($_GET['redirectTo'])) ? $_GET['redirectTo'] : '/';
		$hidden = "<input type='hidden' name='params' value='" . base64_encode(json_encode($atts)) . "'>";
		return '<div data-component="' . $this->base . '" data-redirect="' . $redirect . '" class="mp-component">' . $this->component() . $hidden . '<div class="loader"></div></div>';
	}

	static public function action() {
		$data = json_encode($_POST['data']);
		//error_log($data . PHP_EOL, 3, '/home/mrprint/sandbox.mrprint.com.br/wp-content/plugins/misterprint-ecommerce/erede.log');
		return function () {
			if (
				(!isset($_POST['data']['mp_checkout_e_rede_card']) || !wp_verify_nonce($_POST['data']['mp_checkout_e_rede_card'], 'mp_checkout_e_rede_card_action'))
			) {
				print 'Sorry, your nonce did not verify.';
				exit;
			}

			$data = $_POST['data'];
		};
	}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo checkout e rede card', 'Formulário de Cartão de Crédito'),
			Vc::paramText('Label card number checkout e rede card', 'Número do Cartão'),
		]);
	}
}
