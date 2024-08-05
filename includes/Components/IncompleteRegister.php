<?php

namespace MisterPrint\Components;

use MisterPrint\Factory\Vc;
use MisterPrint\Support\SessionSupport;
use MisterPrint\Support\View;
use MisterPrint\BO\Cliente;

class IncompleteRegister extends Component
{
	protected $name = 'Registro incompleto';
	protected $description = 'Mister Print incomplete register';
	protected $base = 'vc_mp_incomplete_register';

	function render()
	{
		$data = [];
		if (isset($_POST['data']['redirect'])) {
			$data['redirect'] = $_POST['data']['redirect'];
		}

		return (new View('user/incomplete-register', ['params' => $this->getParamsAjax()]))->get();
	}

	// Element HTML
	public function html($atts)
	{
		$redirect = (isset($_GET['redirectTo'])) ? $_GET['redirectTo'] : '/';
		$hidden = "<input type='hidden' name='params' value='" . base64_encode(json_encode($atts)) . "'>";
		return '<div data-component="' . $this->base . '" data-redirect="' . $redirect . '" class="mp-component">' . $this->component() . $hidden . '<div class="loader"></div></div>';
	}

	static public function action()
	{
		return function () {
			if (!isset($_POST['data']['mp_incomplete_register']) || !wp_verify_nonce($_POST['data']['mp_incomplete_register'],
					'mp_incomplete_register_action')) {
				if(wp_redirect(home_url('/cadastro_concluido/'))) {
					exit;
				}
			}

			$data = $_POST['data'];
			$self = new self();

			$data['nome-completo'] = $data['nome-completo'];
			$data['email'] = $data['email'];

			$boCliente = new Cliente();

			$verificacaoDeEmail = $boCliente->verifica_email_existente($data['email']);

			if ($verificacaoDeEmail) {

				return (new View('user/incomplete-register',[
					'params' => $self->getParamsAjax(),
					'errors' => ['Email já Cadastrado']
					]))->get();

				}
				if (!empty($data)) {
					unset($data['params']);
					(new SessionSupport())::set('inclomplete-register', $data);

					$redirect = get_page_url('register');
					return ['redirect' => $redirect];
				}
			};
		}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			// Vc::paramText('Titulo', 'Novo Cliente'),
			Vc::paramText('Titulo', ''),
			//Vc::paramText('Label Nome', 'Nome completo'),
			Vc::paramText('Label celular', 'Celular (DDD)'),
			//Vc::paramText('Placeholder Nome', 'Nome completo'),
			Vc::paramText('Placeholder celular', 'Digite o seu celular'),
			Vc::paramText('Label email', 'E-mail'),
			Vc::paramText('Placeholder email', 'Digite seu e-mail'),
			Vc::paramText('Label confirmação email', 'Confirmar E-mail'),
			Vc::paramText('Placeholder confirmação email', 'Digite novamente seu e-mail'),
			Vc::paramText('Label senha', 'Senha'),
			Vc::paramText('Placeholder senha', 'Digite uma senha'),
			Vc::paramText('Label confirmação senha', 'Confirmação de senha'),
			Vc::paramText('Placeholder confirmação senha', 'Confirme sua senha'),
			Vc::paramText('botão', 'Entrar'),
		]);
	}
}
