<?php
namespace MisterPrint\Components;

use MisterPrint\BO\Carrinho;
use MisterPrint\BO\Produto;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;
use MisterPrint\Support\SessionSupport;

class Button extends Component{
	protected $name = 'Botão';
	protected $description = 'Botão para link fixo';
	protected $base = 'mp_button';

	public function component()
	{
		return '<div data-component="' . $this->base . '" data-ajax="0" style="text-align:center;padding:0px;">'.$this->render().'</div><div class="loader"></div>';
	}

	public function render()
	{
		return (new View('forms/button', ['data' => $this->getParamsAjax()]))->get();
	}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Texto', 'Comprar'),
			Vc::paramText('URL', '#')
		]);
	}
}