import Form from "../Form";

export default function (el) {

	$(el).find(' .mp-category-images-slider').owlCarousel({
		items: 1,
		navText: ["", ""],
		loop: false,
		nav: true,
		autoplay: true,
		autoplayTimeout: 9000,
		autoplayHoverPause: true
	});


	var form  = $(el).find('.mp-add-to-cart-form');
	var input = form.find('[name="quantity"]')


	var rules = [
		{
			'name': 'quantity',
			'rules': {
				minimum: {
					minimum: input.data('minimum'),
					message: 'A quantidade minima é '+input.data('minimum'),
				},
				integer: {
					message: 'A quantidade deve ser inteira'
				}
			}
		},
	];

	new Form(form, rules, () => {
		var form = form.find('mp-form');
		form.data('validation', 'validated');
		form.submit();
	});

	let formContainer = $('.mp-add-to-cart-form');
	if ( formContainer.length ) {

		let form = formContainer.find('form')[0];

		let formatNumber = function ( value ) {
			return new Intl.NumberFormat('pt-BR', { minimumFractionDigits:2, maximumFractionDigits:2 }).format(value);
		}

		let getFormData = function () {

			let values = {};

			$(form).serializeArray().forEach(function ( value ) {

				// Pega o nome do input
				let name = value.name;
				let match = /^([^\[]*)(\[([^\]]*)\])?$/;
				let executedValue = match.exec( name );
				// Tira o grupo do nome do input
				let compiledName = name.replace(/^([^\[]*)\[.*$/, "$1");

				if ( name.startsWith('data[configuration_finishing]') ) {
					values.data = values.data || {};
					values.data.configuration_finishing = values.data.configuration_finishing || [];
					values.data.configuration_finishing.push( value.value );
					return;
				}

				if ( name.includes('[') ) {
					// Caso nao tenha a lista, cria
					if ( executedValue && (executedValue[3] || typeof values[executedValue[1]] == 'object') ) {
						if ( typeof values[executedValue[1]] != 'object' ) {
							values[executedValue[1]] = {};
						}

						// Caso esteja selecionado, adiciona na lista
						values[executedValue[1]][executedValue[3]] = value.value;
					}
					else {
						if ( Array.isArray(values[compiledName]) == false ) {
							values[compiledName] = [];
						}
						// Caso esteja selecionado, adiciona na lista
						values[compiledName].push( value.value );
					}
				}
				else {
					values[compiledName] = value.value;
				}
			});

			return values;
		}

		let xhr;
		let timeout;

		let updateValue = function() {

			if(xhr && xhr.readyState != 4){
				xhr.abort();
			}
			if ( timeout ) {
				clearTimeout( timeout );
				timeout = null;
			}

			$(form).addClass('mp-form-loading');

			timeout = setTimeout(function () {
				let data = Object.assign(
					{
						action:'mp_consult_price_product'
					},
					getFormData()['data']
				);

				xhr = $.ajax({
					url: wp.ajax_url,
					method: 'POST',
					data: {
						action: 'mp_consult_price_product',
						data: data
					},
					success: function(data) {
						$(form).removeClass('mp-form-loading');

						if ( data.price && data.price.status && data.price.status == 'error' ) {
							$(form).find('.mp-errors-container').html( data.price.errorMessage );
							$(form).addClass('mp-form-invalid').removeClass('mp-form-valid');
							return;
						}

						let art = formContainer.find('form [name="data[art]"] option:selected');
						let artPrice = parseFloat(art.data('price'));
						let artPriceMod = parseFloat(art.data('price-mod'));
						if( !isNaN( artPrice ) && !isNaN( artPriceMod ) ){
							artPrice = artPrice + ( artPriceMod * data.price.modulos );
						}
						else{
							artPrice = 0;
						}

						formContainer.find('.mp-prices-table')[artPrice ? 'addClass' : 'removeClass']('has-art');
						formContainer.find('.mp-prices-table')[data.price.preco !== data.price.preco_previo ? 'addClass' : 'removeClass']('has-prev-price');

						formContainer.find('.mp-prev-price [class*="money"]').html( formatNumber(data.price.preco_previo) );
						formContainer.find('.mp-price [class*="money"]').html( formatNumber(data.price.preco) );
						if ( artPrice ) {
							formContainer.find('.mp-art-price').show().find('[class*="money"]').html( formatNumber(artPrice) );
							formContainer.find('.mp-total-price').show().find('[class*="money"]').html( formatNumber(data.price.preco + artPrice) );
						}
						else {
							formContainer.find('.mp-art-price').hide().find('[class*="money"]').html('');
							formContainer.find('.mp-total-price').hide().find('[class*="money"]').html('');
						}
						formContainer.find('.prazo span').html( data.price.prazoDias );
					}
				});
			}, 1000);
		}

		let registerProductFormEvents = () => {
			formContainer.find('input, select').on('change input', updateValue)
		}

		registerProductFormEvents();
		updateValue()
	}

}
