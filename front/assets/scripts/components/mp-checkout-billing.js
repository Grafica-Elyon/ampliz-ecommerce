import StickSidebar from "../StickSidebar";
import Form from "../Form";
import Components from "../Components";
import Factory from "../Factory";
let count=0;
export default function (el) {
	let registerEvents = () => {
		new StickSidebar($('.mp-checkout-sidebar .sidebar-inner', el));

		$('input[name="card-number"]').mask('9999 9999 9999 9999');
		$('input[name="card-valid"]').mask('99/99');
		$('input[name="card-code"]').mask('#999');

		$('[name="payment"]', el).change((event) => {
			let payment = $(event.currentTarget).data('payment');

			$('.mp-checkout-payments [data-inputs]').slideUp();
			$('.mp-checkout-payments [data-inputs="'+payment+'"]').slideDown();
			if(payment == "getnet-iframe"){
				$('[type="submit"]').fadeOut('fast');
			}else{
				$('[type="submit"]').fadeIn('fast');
			}
		});

		$('[name="payment"]:first-child', el).each(function() {
			if($(' [name="payment"]:checked', el).length === 0) {
				$(this).prop("checked", true);
				$(this).change();
			}
		});

		var x2 = $('input.money-input').val() / 100 >= 2 ? true : false;
		var x3 = $('input.money-input').val() / 100 >= 3 ? true : false;
		
		$('input.money-input', el).focusout(() => {
			var x2 = parseFloat($('input.money-input').val()) / 100 >= 2 ? true : false;
			var x3 = parseFloat($('input.money-input').val()) / 100 >= 3 ? true : false;
			if(x2){ $('option[value="2"]').show(); }else{ $('option[value="2"]').hide(); }
			if(x3){ $('option[value="3"]').show(); }else{ $('option[value="3"]').hide(); }
			$('[name="sinal[parcelas]"]')[0].selectedIndex = 0;
		});

		$('input.money-input', el).mask("#.##0,00", {reverse: true});
		$('select[name="sinal[forma]"]', el).change(function () {
			let $this = $(this);
			let option = $this.children('option:selected');
			let showComprovante = option.data('show-comprovante') == 1;
			let showParcelas = option.data('show-parcelas') == 1;

			$('[name="sinal[comprovante]"]').parent()[ showComprovante?'slideDown':'slideUp' ]();
			$('[name="sinal[parcelas]"]').parent()[ showParcelas?'slideDown':'slideUp' ]();
		}).change();

		registerCouponEvents();
		registerCreditEvents();

		let rules = [
			Factory.rule('card', 'Selecione o tipo de cartao'),
			Factory.rule('card-name', 'Nome do cartão de crédito e obrigatório.'),
			Factory.rule('card-number', 'Número do cartão é obrigatório.'),
			Factory.rule('card-valid', 'Validade do cartão é obrigatório.'),
			Factory.rule('card-code', 'Codigo de segurança do cartão é obrigatório.'),
		];

		new Form(el, rules, () => {
			Components.loading(el);
			var form = $(el).find('.mp-form');

			form.data('callback', false);
			form.submit();
		});

	};

	let registerCouponEvents = () => {
		$("input[name=coupon]").on("change paste keyup", function() {
			let cupomMaiusculo = $(this).val().toUpperCase();
			$(this).val(cupomMaiusculo);
		});
		$('.mp-add-coupon', el).on('click', applyCoupon);
	};

	let registerCreditEvents = () => {
		$('[name="credito"]', el).on('change', applyCredit);
	};

	let lastPayment = null;

	let showPaymentForm = () => {
		$('#payment', el).slideDown();
		if ( lastPayment ) {
			$('[name="payment"][value="'+lastPayment+'"]').prop('checked', true);
		}
	}

	let hidePaymentForm = () => {
		$('#payment', el).slideUp();
		let selectedPayment = getInputs()['payment'];
		if ( selectedPayment ) {
			lastPayment = selectedPayment;
			$('[name="payment"][value=""]').prop('checked', true);
		}
	}

	let getInputs = () => {
		let selector = ' input, select';

		let values = {};
		$(selector, el).each((event, element) => {
			if ($(element).attr('type') === "radio") {
				if(element.checked) {
					values[$(element).attr('name')] = $(element).val();
				}
			} else {
				values[$(element).attr('name')] = $(element).val();
			}
		});
		return values;
	};

	function applyCredit() {
		let radio = $('[name="credito"]:checked');
		let credit = parseFloat(0);

		if(radio.val() == 'utilizar') {
			credit = parseFloat(radio.attr('data-credit'));
		}

		let parent = $(' .mp-checkout-order-review', el);

		parent.find("[data-credit-price]").parent()[ credit ? 'show' : 'hide' ]();

		let
			order = parseFloat(parent.find("[data-order-price]").attr('data-order-price')),
			freight = parseFloat(parent.find("[data-freight-price]").attr('data-freight-price')),
			total = parseFloat(parent.find("[data-total-price]").attr('data-total-price')),
			coupon = parseFloat(parent.find("[data-coupon-price]").attr('data-coupon-price'));

		total = order + freight;

		coupon = isNaN(coupon) ? 0 : coupon;

		credit = Math.round( credit * 100 ) / 100;
		order = Math.round( order * 100 ) / 100;
		freight = Math.round( freight * 100 ) / 100;
		total = Math.round( total * 100 ) / 100;
		coupon = Math.round( coupon * 100 ) / 100;
		if(credit >= Math.abs(total - coupon)) {
			credit = total;
			total = 0;

			parent.find("[data-credit-price]")
				.attr("data-credit-price", credit)
				.text(('-R$ '+credit.toFixed(2)).replace(".", ","));

			parent.find("[data-total-price]")
				.attr('data-total-price', total)
				.text(('R$ '+total.toFixed(2)).replace(".", ","));

			hidePaymentForm();
			$('#iframe-script').attr('data-getnet-amount', total.toFixed(2));
			if((total / 100) > 1){
				var parcelas = (total / 100) > '3' ? '3' : ''+parseInt(total / 100);
				$('#iframe-script').attr('data-getnet-installments', parcelas);
			}
		} else if(total==0 && credit == 0 && Math.abs(coupon) > 0){
			credit = total;
			total = 0;
			parent.find("[data-credit-price]").attr("data-credit-price", credit)
				.text(('-R$ '+credit.toFixed(2)).replace(".", ","));
			parent.find("[data-total-price]").attr('data-total-price', total)
				.text(('R$ '+total.toFixed(2)).replace(".", ","));

			hidePaymentForm(); 
			$('#iframe-script').attr('data-getnet-amount', total.toFixed(2));
			if((total / 100) > 1){
				var parcelas = (total / 100) > '3' ? '3' : ''+parseInt(total / 100);
				$('#iframe-script').attr('data-getnet-installments', parcelas);
			}
		} else {
			total = total - credit - coupon;
			parent.find("[data-credit-price]")
				.attr("data-credit-price", credit)
				.text(('-R$ '+credit.toFixed(2)).replace(".", ","));

			parent.find("[data-total-price]")
				.attr('data-total-price', total)
				.text(('R$ '+total.toFixed(2)).replace(".", ","));


			showPaymentForm();
			$('#iframe-script').attr('data-getnet-amount', total.toFixed(2));
			if((total / 100) > 1){
				var parcelas = (total / 100) > '3' ? '3' : ''+parseInt(total / 100);
				$('#iframe-script').attr('data-getnet-installments', parcelas);
			}
		}
		console.log("credito: "+credit+"\n"+"total: "+total+"\n"+"cupom: "+coupon);
		updateCreditPayment()
	}

	function updateCreditPayment()
	{
		// Elemento da parte de parcelas do cartão
		let parcela = $(' #parcelas-cartao', el);
		// Select
		let input = parcela.find('select[name]');

		// Valores vindo do PHP
		let maxParcelas = parcela.data('max-parcelas');
		let minValorParcela = parcela.data('min-valor-parcela');

		let textoParcela = parcela.data('text');
		let textoPrimeiraParcela = parcela.data('text-first');

		// Valor total do pedido segundo a sidebar
		let valorTotal = $('.mp-checkout-order-review [data-total-price]', el).attr('data-total-price');

		// Caso o valor total não passe do minimo, esconde o formulario
		if ( valorTotal < minValorParcela ) {
			input.val(1);
			parcela.hide();
			return;
		}
		// Caso passe, mostra o formulario
		parcela.show();

		// Coleta o numero de parcelas disponíveis
		let quantidadeParcelasDisponiveis = parseInt( valorTotal/minValorParcela );

		// Verificação do número máximo de parcelas
		if ( quantidadeParcelasDisponiveis > maxParcelas ) {
			quantidadeParcelasDisponiveis = maxParcelas;
		}

		// Coleta do html das opções de parcelamento
		let html = '';
		for (var i = 1; i <= quantidadeParcelasDisponiveis; i++) {
			// Texto base configurado no wordpress
			let textoBase;

			// Diferenciação dos textos base
			if ( i == 1 ) {
				textoBase = textoParcela;
			}
			else {
				textoBase = textoPrimeiraParcela;
			}

			// Valores que serão colocados na quantidade
			let replaces = {
				'%qtde%': i,
				'%valor%': ( valorTotal / i ).toFixed( 2 ).toLocaleString(),
			};
			// Realizado a troca dos textos
			for (var key in replaces) {
				textoBase = textoBase.replace(key, replaces[key])
			}

			// Junção do html da opção
			html+= `<option value="${i}">${ textoBase }</option>`;
		}

		// Valor do input antes da troca do html
		let inputVal = input.val();

		// Caso não exista mais a opção, volta para 1
		if ( inputVal > quantidadeParcelasDisponiveis ) {
			inputVal = 1;
		}

		// Troca o html e força o valor
		input.html( html );
		input.val( inputVal );
	}

	function applyCoupon() {
		let coupon = $('[name=coupon]').val();
		if(!coupon) return;
		let couponMessage = $('.mp-coupon-message');
		couponMessage.find('.mp-success').removeClass('active');
		couponMessage.find('.mp-error').removeClass('active');
		Components.loading(el);
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'mp_coupon',
				'data': {
					coupon,
				},
			}
		}).done((response) => {
			Components.loading(el, 'stop');
			$('.mp-checkout-sidebar .sidebar-inner', el).html(response.sidebar);
			$('.mp-checkout-billing-cupom', el).html(response.coupon);
			registerCouponEvents();
			applyCredit();
		});
	}

	function readURL(input) {

	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('#imgComprovante').attr('src', e.target.result);
				mostrarTelaComprovante("#pegarComprovante")

	        }
	        reader.readAsDataURL(input.files[0]);
	    }
	}

	$("#Descartar").click(function(){
		mostrarTelaComprovante("#tela1")
	});

	$("#enviarComprovante").click(function(){
		mostrarTelaComprovante("#comprovanteEnviado")
	});

	$("#previewComprovante").change(function(){
		readURL(this);
	});

	function mostrarTelaComprovante(tela){
		if (tela == "#tela1") {
			$("#tela1").show();
			$("#pegarComprovante").hide();
			$("#comprovanteEnviado").hide();
		}
		if (tela == "#pegarComprovante") {
			$("#tela1").hide();
			$("#pegarComprovante").show();
			$("#comprovanteEnviado").hide();
		}
		if (tela == "#comprovanteEnviado") {
			$("#tela1").hide();
			$("#pegarComprovante").hide();
			$("#comprovanteEnviado").show();
		}

	}
	mostrarTelaComprovante("#tela1")

	function scrollToErrors()
	{
		if($('.mp-errors .mp-field', el).length > 0) {
			$('html, body').animate({
				scrollTop: ($('.mp-errors .mp-field').offset().top - 200)
			}, 800);
		}
	}
	var total = parseFloat($("[data-total-price]").attr('data-total-price'));
	$('#iframe-script').attr('data-getnet-amount', total.toFixed(2));
	registerEvents();
	scrollToErrors();
	applyCredit();
}