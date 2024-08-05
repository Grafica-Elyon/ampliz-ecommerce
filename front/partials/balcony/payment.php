<?php
use MisterPrint\Support\View;
$order = $this->data['order'];

?>
<div data-component="mp_balcony_payment"
	data-ajax="0"
	class="no-style-component"
	data-codigo-pedido="<?= $order ?>">
	<button class="mp-btn-primary mp-btn-sm balcao-realizar-pagamento">Realizar Lançamento</button>
	<div class="mp-modal" data-show="false">
		<div class="mp-painel mp-painel-fix-body flexboxgrid">
			<div class="mp-painel-header">
				<span class="mp-painel-title-sm">
					Lançamento Financeiro
				</span>
				<span class="mp-painel-close">x</span>
			</div>
			<div class="mp-painel-body mp-painel-body-loading row center-xs middle-xs ">
				<div class="body-payment-loading">
					<h2> Carregando </h2>
				</div>
				<div class="body-payment-error">
					<i class="fai fa-warning text-danger mp-text-3x"></i>
					<br>
					<h2> Erro ao carregar as informações </h2>
				</div>
				<div class="body-payment-success">
					<i class="fai fa-check text-success mp-text-3x"></i>
					<br>
					<h2> Pedido quitado com sucesso </h2>
				</div>
				<div class="body-payment-form">
					<h3> Pagamento de sinal </h3>
					<br>
					<br>
					<table class="mp-table balcony-payment-table">
						<tr>
							<td>Total</td>
							<td class="balcony-payment-table-total"></td>
						</tr>
						<tr>
							<td>Crédito</td>
							<td class="balcony-payment-table-credito"></td>
						</tr>
						<tr>
							<td>Desconto</td>
							<td class="balcony-payment-table-desconto"></td>
						</tr>
						<tr>
							<td>Lancamentos</td>
							<td class="balcony-payment-table-lancamentos"></td>
						</tr>
						<tr>
							<td>A Receber</td>
							<td class="balcony-payment-table-areceber"></td>
						</tr>
					</table>
					<br>
					<div class="mp-form">
						<div class="mp-form-group">
							<label class="mp-label"> Valor </label>
							<input class="mp-input text-center" name="valor"/>
						</div>
						<div class="mp-form-group">
							<label class="mp-label"> Tipo de pagamento </label>
							<select class="mp-select" name="tipo">
								<option value="dinheiro" data-show-comprovante="0" selected>Dinheiro</option>
								<option value="credito-vista" data-show-comprovante="1" >Crédito a vista</option>
								<option value="credito-parcelado" data-show-comprovante="1" data-show-parcelas="1">Crédito parcelado</option>
								<option value="bradesco" data-show-comprovante="1" >Bradesco</option>
								<option value="itau" data-show-comprovante="1" >Itaú</option>
								<option value="santander" data-show-comprovante="1" >Santander</option>
								<option value="bb" data-show-comprovante="1" >Banco do Brasil</option>
							</select>
						</div>
						<div class="mp-form-group parcelas" style="display: none;">
							<label class="mp-label"> Parcelas </label>
							<select class="mp-select" name="parcelas">
								<option value="1" selected>1 vez</option>
								<option value="2" >2 vezes</option>
								<option value="3" >3 vezes</option>
							</select>
						</div>
						<div class="mp-form-group">
							<label class="mp-label"> Comprovante </label>
							<input class="mp-input text-center" name="comprovante"/>
						</div>
					</div>
					<br>

					<button type="button" class="mp-btn-primary mp-btn-sm balcao-enviar-pagamento">
						Realizar pagamento
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$ = jQuery;
	$('[name="tipo"]').change(function(){ //mostra ou não parcelas
		if($('[name="tipo"]').val() == "credito-parcelado"){
			$('.parcelas').show('fast');
		}else{
			$('.parcelas').hide('fast');
			$('[name="parcelas"]')[0].selectedIndex = 0;
		}
	});

	$('input[name="valor"]').focusout("keypress",function(){ //recalcula quantidade de parcelas
		var x2 = parseFloat($('input[name="valor"]').val()) / 100 >= 2 ? true : false;
		var x3 = parseFloat($('input[name="valor"]').val()) / 100 >= 3 ? true : false;
		if(x2){ $('option[value="2"]').show(); }else{ $('option[value="2"]').hide(); }
		if(x3){ $('option[value="3"]').show(); }else{ $('option[value="3"]').hide(); }
		$('[name="parcelas"]')[0].selectedIndex = 0;
	});
</script>