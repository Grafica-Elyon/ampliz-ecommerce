<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Cliente;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;

/**
 * Classe com codigo compartilhado com componentes de paineis de usuário
 */
class PanelComponent extends Component
{
	public function setParams()
	{
		parent::setParams();
		$this->addParams([
			Vc::paramText('Titulo', 'Painel do usuário'),
			Vc::paramText('Subtitulo', 'Seu painel administrativo'),
			Vc::paramText('Menu meus pedidos', 'Meus Pedidos'),
			Vc::paramText('Menu meus favoritos', 'Meus Favoritos'),
			Vc::paramText('Menu meus dados', 'Meus Dados'),
			Vc::paramText('Menu meus enderecos', 'Meus Endereços'),
			Vc::paramText('Menu Conta corrente', 'Minha Conta Corrente'),
			Vc::paramText('Menu sair', 'Sair'),
			Vc::paramSidebarPosition('Posição sidebar', 'left'),
		]);
	}
}
