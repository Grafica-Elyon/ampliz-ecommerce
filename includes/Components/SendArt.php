<?php

namespace MisterPrint\Components;

use MisterPrint\BO\Pedido;
use MisterPrint\Factory\Vc;
use MisterPrint\Support\View;
use Carbon\Carbon;

class SendArt extends Component
{
	protected $name = 'Enviar Arte';
	protected $description = 'Ampliz componente para enviar a arte do produto';
	protected $base = 'vc_mp_send_art';

	public function render()
	{
		$data = $_POST['data'];

		$response = (new Pedido)->get_user_token();
		$verificacao = (new Pedido)->check_id_client($data['pedido'], user()->getId());
		$pedido = (new Pedido())->get_detalhes_do_pedido( $data['pedido'] );
		$loja = config("plugin", "franquia");

		$lista = array_filter($pedido['produtosPedido'], function($item) {
			return $item['need_upload'];
		});

		if($loja == 2){
			return (new View('user/send-art', [
				'iframe_url' => config('plugin', 'upload_url'),
				'pedido' => $data['pedido'],
				'produtos' => $lista
			]))->get();
		}else if( isset($response['result']) && $verificacao['success'] ) {
			return (new View('user/send-art', [
				'iframe_url' => config('plugin', 'upload_url').'upload-arte/index/isBalcao/0/idPedido/'.$data['pedido'].'/idCliente/'.user()->getId()
			]))->get();
		} else{
			return (new View('user/send-art', [
				'iframe_url' => null
			]))->get();
		}
	}
	public function component()
	{

		return '<div data-component="' . $this->base . '" data-pedido="'.$_GET['pedido'].'"></div><div class="loader"></div>';
	}
}
