<?php

namespace MisterPrint\Components;

use MisterPrint\Support\View;

class LoginSocial extends Component
{
	protected $name = 'Login Social';
	protected $description = 'Mister Print Login Social';
	protected $base = 'vc_mp_login_social';

	function render()
	{
		return (new View('user/login-social', ['params' => $this->getParamsAjax()]))->get();
	}

	public function setParams()
	{
		$this->params = [
			[
				"type" => "textfield",
				"class" => "",
				"heading" => "Titulo",
				"param_name" => "title",
				"value" => '',
				'default' => 'Acessar conta'
			],
			[
				"type" => "textfield",
				"class" => "",
				"heading" => "Subtitulo",
				"param_name" => "subtitle",
				"value" => '',
				'default' => 'Seu espaço de Registro e Login'
			],
			[
				"type" => "textfield",
				"class" => "",
				"heading" => "Titulo social",
				"param_name" => "title_social",
				"value" => '',
				'default' => 'Faça login através de sua conta social:'
			],
			[
				"type" => "textfield",
				"class" => "",
				"heading" => "Texto de apoio",
				"param_name" => "text_support",
				"value" => '',
				'default' => 'Ou'
			],
		];
	}
}
