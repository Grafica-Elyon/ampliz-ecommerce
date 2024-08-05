import Form from '../Form';
import Components from "../Components";

export default function (el) {

	let $el = $(el);

	if ( window.MrPrint.creation_art_integrator ) {

		let form = window.MrPrint.creation_art_integrator.form_id;
		form = $( '#'+form );
		if ( form.is( 'form' ) == false ) {
			form = form.find('form');
		}

		if ( window.MrPrint.creation_art_integrator.item == null ) {
			$el.parents('.row').siblings().hide();
			return;
		} else {
			let inputs = {
				pedido: window.MrPrint.creation_art_integrator.item.orders_id,
				item: window.MrPrint.creation_art_integrator.item.orders_products_id,
				'nome-cliente': window.MrPrint.creation_art_integrator.cliente.nome,
				email: window.MrPrint.creation_art_integrator.cliente.email,
				celular: window.MrPrint.creation_art_integrator.cliente.celular,
			};
			for (let input in inputs) {
				let existingInput = form.find('[name="'+input+'"]');
				if ( existingInput.length ) {
					existingInput.val( inputs[input] )
					existingInput.parents('.form-input-div').hide()
				} else {
					form.append(
						$(`<input type='hidden' name='${input}' value="${inputs[input]}">`)
					);
				}
			}
		}

		let registerEvents = function () {
			form.on('submit', submit)
		};

		let submit = function ( f ) {
			let responseOutput = form.find('.wpcf7-response-output');
			let i = setInterval(
				function() {
					if ( responseOutput.is(':visible') && responseOutput.attr('role') ) {
						clearInterval( i );

						if ( responseOutput.is('.wpcf7-mail-sent-ok') ) {
							$.ajax({
								url: wp.ajax_url,
								method: 'POST',
								data: {
									action: 'mp_creation_art_submit',
									data: {
										orders_id: window.MrPrint.creation_art_integrator.pedido.orders_id,
										orders_products_id: window.MrPrint.creation_art_integrator.item.orders_products_id,
									}
								}
							})
						}
					}
				},
				50
			);
		};

		registerEvents();
	}
}
