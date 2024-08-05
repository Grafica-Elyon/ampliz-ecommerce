<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Carrinho;
use MisterPrint\BO\Produto;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;
use MisterPrint\Support\SessionSupport;
use MisterPrint\Response\RecoveryPasswordResponse;
use MisterPrint\Request;

class RecoveryPassword extends Component
{
	protected $name = 'Recuperação de Senha';
	protected $description = 'Mister Print componente para o carrinho de compras';
	protected $base = 'vc_mp_recovery_password';

	public function render()
	{

		$session = (new SessionSupport());

		$errors = [];
		if($session::exists('recover-password-errors')) {
			$errors[] = $session::get('recover-password-errors');
			$session::delete('recover-password-errors');
		}

		return (new View('user/password-recovery', [
			'params' => $this->getParamsAjax(),
			'errors' => $errors
		]))->get();
	}

	static public function action()
	{
		return function () {

			$email = $_POST['email'];
			$cpf = $_POST['cpf/cnpj'];

			$request = new Request ( 'user/recuperacao-senha',[
				'email' => $email,
				'cpf' => $cpf
			]);

			$response = new RecoveryPasswordResponse ($request->post());

			$body = $response->body;
			$errors = $body['message'];

			(new SessionSupport())::set('recover-password-errors', $errors);

			if ($errors == 'success') {
				wp_redirect(get_page_url('password_recovery'));			}
			else {
				wp_redirect(get_page_url('password_recovery'));
			}
		};
	}

	public function setParams()
	{
		$this->addParams([
			Vc::paramText('Titulo', 'Carrinho'),
			Vc::paramText('Subtitulo', 'Vamos conferir seu carrinho de compras?'),
			Vc::paramText('Titulo da tabela', 'Confirmação do pedido'),
			Vc::paramText('Subtitulo da tabela', 'As informações do seu pedido estão corretas?'),
			Vc::paramText('Titulo do botão preto', 'Comprar outro produto'),
			Vc::paramText('Titulo do botao vermelho', 'Continuar'),
			Vc::paramText('Sem itens', 'Você ainda não tem itens no carrinho.'),
		]);
	}
}
