<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Frete;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;

class ListaFretes extends Component
{
	protected $name = 'Lista de fretes';
	protected $description = 'Mister Print componente para listar todos os fretes';
	protected $base = 'vc_mp_lista_fretes';

	public function render(){
		$frete = new Frete();
		$balconies = $frete->get_todos_balcoes();
		$data = array(
			'balconies' => $balconies,
			'params' => $this->getParamsAjax(),
		);
		return (new View('shipping/freights', $data))->get();
	}

	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo', 'Nossos balcões'),
			Vc::paramText('Subtitulo', 'Veja na lista os nossos pontos de entrega'),
		]);
	}

}
