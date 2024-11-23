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

	 // Método de ação para validação e redirecionamento
	 public static function action()
	 {
		 return function () {
			 // Validação de nonce para segurança
			 if (
				 !isset($_POST['data']['mp_incomplete_register']) ||
				 !wp_verify_nonce($_POST['data']['mp_incomplete_register'], 'mp_incomplete_register_action')
			 ) {
				 wp_redirect(home_url('/cadastro_concluido/'));
				 exit;
			 }
 
			 // Captura os dados enviados
			 $data = $_POST['data'];
 
			 // Validação do e-mail
			 if (empty($data['email-incomplete-register']) || !filter_var($data['email-incomplete-register'], FILTER_VALIDATE_EMAIL)) {
				 return (new View('user/incomplete-register', [
					 'params' => (new self())->getParamsAjax(),
					 'errors' => ['E-mail inválido ou ausente!'],
				 ]))->get();
			 }
 
			 // Valida se o e-mail já existe
			 $boCliente = new Cliente();
			 if ($boCliente->verifica_email_existente($data['email-incomplete-register'])) {
				 return (new View('user/incomplete-register', [
					 'params' => (new self())->getParamsAjax(),
					 'errors' => ['E-mail já cadastrado!'],
				 ]))->get();
			 }
 
			 // Validação do celular
			 if (empty($data['celular-incomplete-register']) || strlen($data['celular-incomplete-register']) < 15) {
				 return (new View('user/incomplete-register', [
					 'params' => (new self())->getParamsAjax(),
					 'errors' => ['Celular inválido ou incompleto!'],
				 ]))->get();
			 }
 
			 // Fluxo de sucesso
			 unset($data['params']); // Remove campos desnecessários
			 (new SessionSupport())->set('incomplete-register', $data);
 
			 wp_redirect(home_url('/cadastro_concluido/'));
			 exit;
		 };
	 }


	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo incomplete register', 'Novo Cliente - Cadastre-se'),
			Vc::paramText('Label Nome incomplete register', 'Nome completo'),
			Vc::paramText('Label celular incomplete register', 'Celular (DDD)'),
			Vc::paramText('Placeholder Nome incomplete register', 'Nome completo'),
			Vc::paramText('Placeholder celular incomplete register', 'Digite o seu celular'),
			Vc::paramText('Label email incomplete register', 'E-mail'),
			Vc::paramText('Placeholder email incomplete register', 'Digite seu e-mail'),
			Vc::paramText('Label confirmação email incomplete register', 'Confirmar E-mail'),
			Vc::paramText('Placeholder confirmação email incomplete register', 'Digite novamente seu e-mail'),
			Vc::paramText('Label senha incomplete register', 'Senha'),
			Vc::paramText('Placeholder senha incomplete register', 'Digite uma senha'),
			Vc::paramText('Label confirmação senha incomplete register', 'Confirmação de senha'),
			Vc::paramText('Placeholder confirmação senha incomplete register', 'Confirme sua senha'),
			Vc::paramText('Button incomplete register', 'Cadastrar'),
		]);
	}
}
