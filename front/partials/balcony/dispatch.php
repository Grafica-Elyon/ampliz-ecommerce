<?php
use MisterPrint\Support\View;
$order = $this->data['order'];

?>
<div data-component="mp_balcony_dispatch"
	data-ajax="0"
	class="no-style-component"
	data-codigo-pedido="<?= $order ?>">
	<button class="mp-btn-primary mp-btn-sm balcao-realizar-despacho"> Despachar pedido </button>
	<div class="mp-modal" data-show="false">
		<div class="mp-painel mp-painel-auto-height flexboxgrid">
			<div class="mp-painel-header">
				<span class="mp-painel-title-sm">
					Confirmação obrigatória
				</span>
				<span class="mp-painel-close">x</span>
			</div>
			<div class="mp-painel-body mp-painel-body-loading row center-xs middle-xs ">
				<div class="body-dispatch-loading">
					<h2> Carregando </h2>
				</div>
				<div class="body-dispatch-error">
					<i class="fai fa-warning text-danger mp-text-3x"></i>
					<br>
					<h2> Erro ao carregar as informações </h2>
				</div>
				<div class="body-dispatch-success">
					<i class="fai fa-check text-success mp-text-3x">
					</i>
					<br>
					<h2>Despachado com sucesso</h2>
				</div>
				<div class="body-dispatch-confirm">
					<h3> Você tem certeza que<br>quer despachar o pedido? </h3>
					<br><br>
					<div class="row around-xs">
						<button type="button" class="mp-btn-black mp-btn-sm col-xs-5 col-md-4 balcao-cancelar">
							Não
						</button>
						<button type="button" class="mp-btn-primary mp-btn-sm col-xs-5 col-md-4 balcao-despachar">
							Sim
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
