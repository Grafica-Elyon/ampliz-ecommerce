import Components from '../Components.js';

export default function ( el ) {

	let $el = $(el);
	let modal = $el.find('.mp-modal');

	let xhr;

	let showModal = () => {
		modal.addClass('active');
		$('html').css('overflow', 'hidden');
		setModalStatus( MODAL_STATUS_CONFIRM );
	}

	let hideModal = () => {
		modal.removeClass('active');
		$('html').css('overflow', '');

		if(xhr && xhr.readyState != 4){
			xhr.abort();
			xhr = null;
		}
	}

	const MODAL_STATUS_LOADING = 'loading';
	const MODAL_STATUS_ERROR = 'error';
	const MODAL_STATUS_SUCCESS = 'success';
	const MODAL_STATUS_CONFIRM = 'confirm';

	let setModalStatus = ( status ) => {
		let list = [MODAL_STATUS_LOADING, MODAL_STATUS_ERROR, MODAL_STATUS_CONFIRM, MODAL_STATUS_SUCCESS];
		if ( list.includes(status) == false ) {
			console.log('Erro, '+status+' não encontrado na lista de status');
			return;
		}

		let modalBody = modal.find('.mp-painel-body');
		list.forEach((s) => modalBody.removeClass('mp-painel-body-'+s));

		modalBody.addClass('mp-painel-body-'+status);
	}

	let showError = ( message ) => {
		let errorContainer = modal.find('.mp-painel-body .body-dispatch-'+MODAL_STATUS_ERROR);
		errorContainer.find('h2').html(message);
		setModalStatus( MODAL_STATUS_ERROR )
	}

	let enviar = () => {
		setModalStatus( MODAL_STATUS_LOADING )
		xhr = $.ajax({
			url: wp.ajax_url,
			method: 'POST',
			data: {
				action: 'mp_balcony_make_dispatch',
				data: {
					codigoPedido: $el.data('codigo-pedido'),
				}
			},
			success: function(data) {
				if ( data.status == 'error' ) {
					showError("Erro na requisição:<br>"+data.message);
					setTimeout(setModalStatus, 3000, MODAL_STATUS_CONFIRM);
				}
				else {
					setModalStatus(MODAL_STATUS_SUCCESS)
					setTimeout(()=>{
						hideModal();
						(new Components).reload( $el.parents('[data-component]')[0] );
					}, 3000);
				}
			}
		});
	}

	let registerEvents = () => {
		modal.children().on('click', e => e.stopPropagation());

		modal.on('click', hideModal);
		modal.find('.mp-painel-close, .balcao-cancelar').on('click', hideModal);

		$el.find('.balcao-realizar-despacho').click(showModal);
		$el.find('.balcao-despachar').click(enviar);
	}

	registerEvents();

}
