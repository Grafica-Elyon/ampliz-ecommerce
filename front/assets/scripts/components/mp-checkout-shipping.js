import Form from "../Form";
import Components from "../Components";
import StickSidebar from "../StickSidebar";
import Factory from "../Factory";
import Maps from "../Maps";

export default function (el) {
	// Opções selecionadas
	let getInputs = () => {
		let values = {};
		$(' input, select', el).each((event, element) => {
			if ($(element).attr('type') === "radio" && element.checked) {
				values[$(element).attr('name')] = $(element).val();
			}

			if(($(element).attr('type') === "text" || $(element).is('select')) && $(element).is(':visible')) {
				values[$(element).attr('name')] = $(element).val();
			}

			if($(element).attr('type') === "hidden") {
				values[$(element).attr('name')] = $(element).val();
			}
		});
		return values;
	};

	function registerEvents() {

		/* Tipo de entrega */
		$('[name="shipping_type"]', el).change(typeChanged);

		// Endereços de entrega
		$('[name="address"]', el).change(addressChanged);

		// Endereços de entrega
		$('[name="shipping"]', el).change(shippingChanged);

		// Frete selecionado
		$('[name="shipping_code"]', el).change(shippingCodeChanged);

		// Balcões
		$('[name="tipo-procura-balcao"]', el).change(searchBalconiesTypeChanged);
		$(' #get_balconies', el).click(getBalconies);
		$(' [name="balcony_state"]', el).change(function() {
			$(' [name="balcony_cep"]', el).val('');
		});

		setTimeout( () => {
			// Balcões
			$(' #get_remessa', el).click(getRemessas);
		}, 500);

		setTimeout( () => {
			$('[name="direct_cep"]').change(function(){
				if($(this).val().length == 9){
					getRemessas();
				}
			});
		}, 500);

		// Modal de cadastro de endereço
		$('.mp-btn-modal').on('click', showModal);
		$(document).on('click', '.mp-modal .mp-close', closeModal);

		$('#cep').mask('00000-000');
		$('[name="direct_cep"]').mask('00000-000');

		$('[name="balcony_cep"]').mask('00000-000');

		$('#telefone').mask('(00) 0000-00000');

		$('#tipo-documento button', el).click(documentTypeChanged);
		$('#tipo-documento button.mp-btn-primary', el).click();

		$('[name="direct_value"]', el).mask("#.##0,00", {reverse: true});

		formSubmit();
		new StickSidebar($('.mp-checkout-sidebar .sidebar-inner', el));
	}

	function typeChanged() {
		var type = $('[name="shipping_type"]:checked').val();

		if($('[data-type]:visible').length > 0) {
			$('[data-type]').slideUp(200);
		}

		$('[data-type="'+type+'"]').slideDown(250);

		if('withdraw' == type) {
			getBalconies();
		}

		if('shipping' == type) {
			addressChanged();
		}
	}


	function shippingChanged() {
		var shipping = $(' [name="shipping"]:checked', el).val();

		if($('[data-shipping]:visible').length > 0) {
			$('[data-shipping]').slideUp(200);
		}

		$('[data-shipping="'+shipping+'"]').slideDown(250);
	}

	function shippingCodeChanged() {
		let checkedShipping = $(' [name="shipping_code"]:checked', el),
			shipping_value = checkedShipping.attr('data-value'),
			shipping_prazo = checkedShipping.attr('data-prazo'),
			shipping_codigo = checkedShipping.val(),
			shipping_titulo = checkedShipping.attr('data-titulo'),
			sub_total = $(' .mp-checkout-order-review [data-order-price]', el).attr('data-order-price'),
			discount = 0;

		// $(' .mp-checkout-details .mp-shipping-detail', el).fadeOut()

		if($(' .mp-checkout-order-review [data-discount-price]', el).length > 0) {
			discount = parseFloat($(' .mp-checkout-order-review [data-discount-price]', el).attr('data-discount-price'))
		}
		if($(' .mp-checkout-order-review [data-coupon-price]', el).length > 0) {
			discount += parseFloat($(' .mp-checkout-order-review [data-coupon-price]', el).attr('data-coupon-price'))
		}
		if(isNaN(discount)){
			discount = 0.0;
		}
        shipping_value = parseFloat(shipping_value);
		let total = parseFloat(sub_total) + shipping_value;
		if(shipping_prazo != '-'){
			let diasSemana = ["Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado"];
			let dataArr = shipping_prazo.split("/");
			let dataStr = dataArr.reverse().join(',');
			let data = new Date(dataStr);
			let diaSemanaPrazo = data.getDay();
			let diaSemanaPrazoStr = diasSemana[diaSemanaPrazo];

			$(' .mp-checkout-order-review [data-freight-price]', el).text(('R$ '+shipping_value.toFixed(2)).replace(".", ","));
			$(' .mp-checkout-order-review [data-total-price]', el).text(('R$ '+total.toFixed(2)).replace(".", ","));
			$(' .mp-shipping-detail', el).html("<strong>"+shipping_codigo+"</strong> "+shipping_titulo);
			$(' .mp-shipping-date', el).text(shipping_prazo);
			$(' .mp-arrival-day-week', el).text(diaSemanaPrazoStr);
		}else{
			$(' .mp-checkout-order-review [data-freight-price]', el).text(('R$ '+shipping_value.toFixed(2)).replace(".", ","));
			$(' .mp-checkout-order-review [data-total-price]', el).text(('R$ '+total.toFixed(2)).replace(".", ","));
			$(' .mp-shipping-detail', el).html("<strong>"+shipping_codigo+"</strong> "+shipping_titulo);
			$(' .mp-shipping-date', el).text('');
			$(' .mp-arrival-day-week', el).text('');
		}
	}

	function addressChanged() {
		Components.loading(el);
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'mp_shipping_price',
				'params': $(' [name="params"]', el).val(),
				'data': getInputs(),
			},
		}).done((response) => {
			Components.loading(el, 'stop');
			$(el).html(response);
			registerEvents();
		});
	}

	function searchBalconiesTypeChanged() {
		var type = $('[name="tipo-procura-balcao"]:checked').val();
		$('.forma-de-procura', el).hide().each(function () {
			let $this = $(this);
			if ( [type, 'all'].includes( $this.data('tipo') ) ) {
				$this.show();
			}
		});
		shippingCodeChanged();
	}

	function getBalconies() {
		Components.loading(el);
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'mp_balconies',
				'params': $(' [name="params"]', el).val(),
				'data': getInputs(),
			},
		}).done((response) => {
			Components.loading(el, 'stop');
			$(el).html(response.html);
			registerEvents();
		});
	}



	function getRemessas() {
		Components.loading(el);
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'mp_remessas',
				'params': $(' [name="params"]', el).val(),
				'data': getInputs(),
			},
		}).done((response) => {
			Components.loading(el, 'stop');
			$(el).html(response.html);

			registerEvents();
		});
	}

	function formSubmit() {
		$(' .mp-category-config-form [type="submit"]', el).prop("disabled", false);

		let rules = [
			Factory.rule('shipping_type', 'Por favor, Selecione entrega ou retirada!'),
			Factory.rule('address', 'Cadastre um endereço em "Meus endereços" para continuar'),
			Factory.rule('shipping', 'Selecione uma forma de entrega.'),
			Factory.rule('shipping_code', 'Selecione uma forma de entrega.'),
			Factory.rule('balcony_cep', 'Digite o CEP.'),
			Factory.rule('direct_name', 'O nome do destinatário é obrigatório'),
			Factory.rule('direct_document', 'O documento do destinatário é obrigatório'),
			Factory.rule('direct_value', 'O valor declarado ao cliente é obrigatório'),
			Factory.rule('direct_endereco', 'O endereço completo é obrigatório'),
			Factory.rule('direct_numero', 'O número do endereço é obrigatório'),
			Factory.rule('direct_bairro', 'O bairro é obrigatório'),
			Factory.rule('direct_cidade', 'A cidade é obrigatório'),
			Factory.rule('direct_uf', 'O Estado é obrigatório'),
		];

		new Form(el, rules, () => {
			Components.loading(el);
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: 'mp_checkout_shipping',
					'data': getInputs()
				}
			}).done((response) => {
				if(response.redirect) {
					window.location = response.redirect;
				}
			});
		});
	}

	function cacheFreightPrice(val) {
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'mp_cache_freight',
				'data': {
					freight_price: val,
				}
			}
		});
	}

	function showSelect() {
		$('.mp-selects [data-shipping]').slideUp();
		$(`.mp-selects [data-shipping="${this.value}"]`).slideDown();
	}

	function showModal (e) {
		e.preventDefault();
		let form = $('.mp-add-address');
		if(!$('.mp-modal').length) {
			$('body').append(`<div class="mp-modal">
				<div class="mp-modal-inner"></div>
				<div class="loader"></div>
			</div>`);
			Form.cep($('.mp-modal .mp-modal-inner'));
		}
		let modal = $('.mp-modal');
		modal.find('.mp-modal-inner').html(form.first());

		$('.mp-modal form').on('submit', addAddress);
		modal.addClass('active');
	}

	function closeModal (e) {
		e.preventDefault();
		$(e.currentTarget).closest('.mp-modal').removeClass('active');
	}

	function documentTypeChanged(e) {
		let $this = $(this);
		let $siblings = $this.siblings();
		let type = $this.val();

		$this.addClass('mp-btn-primary');
		$this.removeClass('mp-btn-darker-transparent');

		$siblings.addClass('mp-btn-darker-transparent');
		$siblings.removeClass('mp-btn-primary');

		$('[name="direct_document_type"]').val(type);

		switch (type) {
			case "cpf":
				$('[name="direct_document"]')
					.attr('placeholder', '000.000.000-00')
					.mask('000.000.000-00');
				break;
			case "cnpj":
				$('[name="direct_document"]')
					.attr('placeholder', '00.000.000/0000-00')
					.mask('00.000.000/0000-00');
				break;
			default:
				console.log("Erro na seleção do tipo do documento. Tipo: ", type);
		}
	}

	function addAddress (e) {
		e.preventDefault();
		let form = $('.mp-add-address');
		Components.loading(el);
		let data = form.serializeArray();
		$(e.currentTarget).closest('.mp-modal').removeClass('active');
		$.ajax({
			method: 'POST',
			url: wp.ajax_url,
			data: {
				action: 'mp_save_address',
				data,
			}
		}).done(() => {
			Components.loading(el, 'stop');
			new Components();
		});
	}

	registerEvents();
}
