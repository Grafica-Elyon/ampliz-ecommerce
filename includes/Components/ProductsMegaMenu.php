<?php
namespace MisterPrint\Components;

use MisterPrint\BO\Produto;
use MisterPrint\Support\MenuTree;
use MisterPrint\Support\View;

class ProductsMegaMenu extends Component
{
	protected $name = 'Mega Menu';
	protected $description = 'Mega Menu de produtos';
	protected $base = 'mp_mega_menu';

	public function html( $attr )
	{
		return $this->render();
	}

	public function render()
	{
		$productBO = new Produto();

		$grupos = json_decode( $productBO->get_grupos_de_produtos(), true );
		$itens = json_decode( $productBO->get_produtos_mega_menu(), true );

		if ( empty( $grupos ) || empty( $itens ) || ! is_array( $grupos ) || ! is_array( $itens ) ) {
			return '';
		}

		return ( new View( 'menu/do-mega-menu', array(
			'grupos' => $grupos,
			'arvore' => MenuTree::porGrupo( $itens, $grupos ),
		) ) )->get();
	}
}
