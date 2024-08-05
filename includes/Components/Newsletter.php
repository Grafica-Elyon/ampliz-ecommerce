<?php

namespace MisterPrint\Components;

use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;
use MisterPrint\BO\Newsletter as NewsletterBO;

class Newsletter extends Component
{
	protected $name = 'Newsletter';
	protected $description = 'Mister Print Newsletter';
	protected $base = 'vc_mp_newsletter';

	public function render()
	{
		return (new View('newsletter/newsletter', ['params' => $this->getParamsAjax()]))->get();
	}

	static public function action()
	{
		return function () {
			$email = sanitize_email($_POST['email']);
			$newsletter = (new NewsletterBO())->registrar_newsletter($email);

			if ($newsletter) {
				$sent = true;
			} else {
				$sent = false;
			}

			return (new View('newsletter/newsletter', [
				'sent' => $sent,
				'params' => json_decode(base64_decode($_POST['params']), true),
			]))->get();
		};
	}

	public function setParams()
	{
		$this->addParams([
			Vc::paramText('Titulo', 'Assine nossa newsletter para receber novidades e ofertas exclusivas.'),
			Vc::paramText('Placeholder', 'Informe seu e-mail aqui para assinar'),
			Vc::paramText('Botão', 'Assinar'),
		]);
	}
}
