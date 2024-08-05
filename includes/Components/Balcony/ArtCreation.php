<?php

namespace MisterPrint\Components\Balcony;

use MisterPrint\Components\Component;
use MisterPrint\Support\View;

use MisterPrint\Response\BalconyArtCreationModels;
use MisterPrint\Response\BalconyArtCreationRegister;

class ArtCreation extends Component
{
	protected $name = 'Criação de Arte';
	protected $description = 'Mister Print Pedido de Criação de Arte';
	protected $base = 'mp_balcony_art_creation';


	function __construct($register = false)
	{
		parent::__construct( false );
	}

	function render()
	{
		return (new View('balcony/art_creation/form', [
			'product_types' => BalconyArtCreationModels::get(),
			'params' => $this->getParamsAjax()
		]))->get();
	}

	public static function send()
	{
		return function (  ) {
			$data = $_POST;

			unset( $data['action'] );

			$data['artes'] = array_map(
				function ($a) {
					return [
						'modelo' => $_POST['tipo_produto'][$a],
						'processo_referencia' => $_POST['processo_referencia'][$a],
					];
				},
				range(0, sizeof($_POST['txtProcessoReferencia']) - 1)
			);

			unset( $data['tipo_produto'] );
			unset( $data['processo_referencia'] );

			return BalconyArtCreationRegister::get( $data );
		};
	}
}
