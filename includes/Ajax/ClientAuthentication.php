<?php
namespace MisterPrint\Ajax;

use MisterPrint\BO\User;

class ClientAuthentication extends Ajax
{

	private $user;
	private $data = [];

	public function init()
	{
		$this->user       = new User();
		$this->data = [
			'email'         => isset($_POST['email']) ? $_POST['email'] : false,
			'senha'         => isset($_POST['senha']) ? $_POST['senha'] : false,
		];

	}

	public function handle()
	{
		$this->init();
		$ajax_return = $this->user->login($this->data);
		return $ajax_return;
	}

}
