<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Cliente;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;

class PanelFavorites extends PanelComponent
{
	protected $name = 'Painel de favoritos';
	protected $description = 'Painel com os favoritos do usuário';
	protected $base = 'vc_mp_panel_favorites';

	public function render()
	{
		return (new View('user/panel-favorites', [
			'params' => $this->getParamsAjax(),
			'favorites' => (new Cliente())->buscar_favoritos(),
		]))->get();
	}


	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo', 'Favoritos'),
			Vc::paramText('Titulo painel', 'Meus Favoritos'),
			Vc::paramText('Posição da sidebar', 'left'),
		]);
	}
}
