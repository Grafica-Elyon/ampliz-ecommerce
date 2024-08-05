<?php 
namespace MisterPrint\Components;
use MisterPrint\Support\View;
use MisterPrint\Support\Request as Fetch;
use MisterPrint\Factory\Vc;

class Coupon extends Component{
	protected $name = 'Pedidos no cupom';
	protected $description = 'Componente para lista de pedidos no cupom da semana';
	protected $base = 'mp_coupon';

	public function render(){
		if(!user()->getId()){
			if(wp_redirect("/")){ exit(); }
		}

		$dados = (new Fetch("pedidos-para-cupom/".user()->getId()))->get();
		//$dados = (new Fetch("pedidos-para-cupom/829992"))->get([]);
		$dados = json_decode($dados['body']);
		if(!isset($dados->pedidos)){ $dados = []; }
		
		return (new View('user/coupon', [
			'dados' => $dados,
			'params' => $this->getParamsAjax()
		]))->get();
	}

	public function setParams(){
		$this->addParams([
			Vc::paramText('Titulo', 'Pedidos da semana'),
			Vc::paramText('Subtitulo', 'Vamos conferir sua semana de compras?'),
			Vc::paramText('Titulo sem pedidos', 'Nenhum Pedido até o momento!'),
			Vc::paramText('Subtitulo sem pedidos', 'Feche uma compra e comece a ganhar descontos'),
		]);
	}
}
