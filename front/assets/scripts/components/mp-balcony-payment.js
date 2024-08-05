import Components from '../Components.js';

export default function ( el ) {

	let $el = $(el);
	let modal = $el.find('.mp-modal');

	let xhr;

	let showModal = () => {
		modal.addClass('active');
		$('html').css('overflow', 'hidden');
		loadModalInfo();
	}

	let hideModal = () => {
		modal.removeClass('active');
		$('html').css('overflow', '');

		if(xhr && xhr.readyState != 4){
			xhr.abort();
			xhr = null;
		}
	}

	let loadModalInfo = () => {
		setModalStatus( MODAL_STATUS_LOADING );

		xhr = $.ajax({
			url: wp.ajax_url,
			method: 'POST',
			data: {
				action: 'mp_balcony_payment_info',
				data: {
					codigoPedido: $el.data('codigo-pedido')
				}
			},
			success: function(data) {
				setModalStatus( MODAL_STATUS_FORM );
				let successBody = modal.find('.body-payment-form');

				successBody.find('.balcony-payment-table-total').html(data.pedido.valores.total);
				successBody.find('.balcony-payment-table-lancamentos').html(data.pedido.valores.total_lancamentos);
				successBody.find('.balcony-payment-table-desconto').html(data.pedido.valores.desconto);
				successBody.find('.balcony-payment-table-areceber').html((data.pedido.valores.total_areceber).replace(".",","));
				successBody.find('.balcony-payment-table-credito').html(data.pedido.valores.credito);
				if ( data.pedido.valores.credito == 0 ) {
					$('.balcony-payment-table-credito').parent().hide();
				}

				if ( data.pedido.valores.total_areceber == 0 ) {
					setModalStatus( MODAL_STATUS_SUCCESS );
					setTimeout(()=>{
						hideModal();
						(new Components).reload( $el.parents('[data-component]')[0] );
					}, 3000);
				}
			}
		});
	}

	const MODAL_STATUS_LOADING = 'loading';
	const MODAL_STATUS_ERROR = 'error';
	const MODAL_STATUS_SUCCESS = 'success';
	const MODAL_STATUS_FORM = 'form';

	let setModalStatus = ( status ) => {
		let list = [MODAL_STATUS_LOADING, MODAL_STATUS_ERROR, MODAL_STATUS_SUCCESS, MODAL_STATUS_FORM];
		if ( list.includes(status) == false ) {
			console.log('Erro, '+status+' não encontrado na lista de status');
			return;
		}

		let modalBody = modal.find('.mp-painel-body');
		list.forEach((s) => modalBody.removeClass('mp-painel-body-'+s));

		modalBody.addClass('mp-painel-body-'+status);
	}

	let showError = ( message ) => {
		let errorContainer = modal.find('.mp-painel-body .body-payment-'+MODAL_STATUS_ERROR);
		errorContainer.find('h2').html(message);
		setModalStatus( MODAL_STATUS_ERROR )
	}

	let enviar = () => {
		let valorAReceber = modal.find('.body-payment-success .balcony-payment-table-areceber').html();
		let valorDoPagamento = $el.find('input[name="valor"]').val();

		if ( valorDoPagamento == 0 ) {
			showError("Valor obrigatório");
			setTimeout(setModalStatus, 3000, MODAL_STATUS_FORM);
			return;
		}
		if ( valorDoPagamento > valorAReceber ) {
			showError("Valor inserido maior que valor para receber");
			setTimeout(setModalStatus, 3000, MODAL_STATUS_FORM);
			return;
		}

		let formaPgto = $el.find('select[name="tipo"]').val();
		let comprovante = $el.find('input[name="comprovante"]').val();
		let parcelas = $el.find('[name="parcelas"]').val();

		xhr = $.ajax({
			url: wp.ajax_url,
			method: 'POST',
			data: {
				action: 'mp_balcony_make_payment',
				data: {
					codigoPedido: $el.data('codigo-pedido'),
					valorDoPagamento: valorDoPagamento,
					formaPgto: formaPgto,
					comprovante: comprovante,
					parcelas: parcelas,
				}
			},
			success: function(data) {
				if ( data.status == 'error' ) {
					showError("Erro na requisição:<br>"+data.message);
					setTimeout(setModalStatus, 3000, MODAL_STATUS_FORM);
				}
				else {
					showModal();
				}
			}
		});
	}

	let registerEvents = () => {
		modal.children().on('click', e => e.stopPropagation());

		modal.on('click', hideModal);
		modal.find('.mp-painel-close').on('click', hideModal);

		$el.find('.balcao-realizar-pagamento').click(showModal);
		$el.find('.balcao-enviar-pagamento').click(enviar);

		let campo = $el.find('input[name="valor"]');
		campo.mask(
			"0000.00",
			{
				reverse: true,
				onChange: function( medida ){
					let replaces = [
						// Tira os 0 à esquerda
						[/^0+([0-9]+[\.,])/, "$1"],
						// Caso não tenha nenhum número, ele adiciona o 0.
						[/^([0-9]+)$/, "0.$1"],
						// Quando não tiver nada, volta para 0.00
						[/^$/, "0.00"]
					];
					let medidaMudada = medida;
					replaces.forEach(function (r) {
						medidaMudada = medidaMudada.replace(r[0], r[1]);
					})
					campo.val(medidaMudada);
				},
			}
		);
		if ( campo.val() == "" ) {
			campo.val( "0.00" )
		}
	}

	registerEvents();

}
