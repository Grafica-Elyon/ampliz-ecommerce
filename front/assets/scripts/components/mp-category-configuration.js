import Components from '../Components';
import Form from '../Form'
import StickSidebar from '../StickSidebar';
import Factory from "../Factory";

export default function (el) {
	// Opções selecionadas
	let getInputs = (all) => {
		let selector = all
			? ' .mp-category-config-form input'
			: ' .mp-category-config-form .mp-config-print-options input';

		let values = {};
		$(selector, el).each((event, element) => {
			if ( $(element).is('.finish-input') ) {
				// Pega o nome do input
				let name = $(element).attr('name');
				// Tira o grupo do nome do input
				let compiledName = name.replace(/^([^\[]*)\[.*$/, "$1");
				// Caso nao tenha a lista, cria
				if ( Array.isArray(values[compiledName]) == false ) {
					values[compiledName] = [];
				}
				// Caso esteja selecionado, adiciona na lista
				if ( element.checked ) {
					values[compiledName].push( $(element).val() );
				}
			}
			else if ($(element).attr('type') === "radio") {
				if(element.checked) {
					values[$(element).attr('name')] = $(element).val();
				}
			} else {
				values[$(element).attr('name')] = $(element).val();
			}
		});

		values['custom_quantity_input'] = values['custom_quantity'];
		delete values['custom_quantity'];

		let productChecked = $("input[name='product']:checked", el).parent();
		if ( productChecked.length ) {
			values['peso']  = parseFloat(productChecked.data('peso'));
			values['modulos']  = parseFloat(productChecked.data('modulos'));
			values['valor'] = parseFloat(productChecked.find('.mp-checkbox-label').text().replace('R$ ', '').replace(',', '.'));
			values['custom_quantity'] = productChecked.data('qtde') ? parseInt(productChecked.data('qtde')) : null;
		}

		values['category_id'] = $('div[data-category]').attr('data-category');

		return values;
	};

	let configChanged = (event) => {
		let inputs = getInputs();
		let data = $(el).data();
		let params = $(el).closest('.mp-component').find('input[name="params"]').val();

		let input = $('.mp-config-print-options [name="configuration_format"]:checked');

		if(input.attr('name') == 'configuration_format' && input.val() == 'custom') {
			$(' .mp-sob-medida', el).fadeIn('fast');

			let width_input = $('.mp-sob-medida [name="sob_medida_width"]', el),
				height_input = $('.mp-sob-medida [name="sob_medida_height"]', el);

			let width = width_input.val(),
				height = height_input.val(),
				width_min = parseInt(width_input.attr('data-min')),
				width_max = width_input.attr('data-max'),
				height_min = parseInt(height_input.attr('data-min')),
				height_max = height_input.attr('data-max');

			width_max = (width_max == '') ? 999999 : parseInt(width_max);
			height_max = (height_max == '') ? 999999 : parseInt(height_max);

			if(width == '' || height == '') {
				return;
			}

			if(width < width_min || height < height_min || width > width_max || height > height_max) {
				$(' .mp-sob-medida .mp-message', el).addClass('mp-error')
				return;
			} else {
				$(' .mp-sob-medida .mp-message', el).removeClass('mp-error')
			}
		} else {
			$(' .mp-sob-medida', el).fadeOut('fast');
		}

		updateUrl( event.target.name );
		var step = event.target.name;
		inputs = {};
		inputs.configuration_art = $('.art input:checked').val();
		if($('[name="configuration_format"]:checked').val() == 'custom') {
			inputs.sob_medida_width = $('[name="sob_medida_width"]').val();
			inputs.sob_medida_height = $('[name="sob_medida_height"]').val();
			inputs.configuration_format = 'custom';
		}else{
			inputs.configuration_format = $('[name="configuration_format"]:checked').val();
		}
		if(step == 'configuration_color' || step == 'configuration_format'){
			inputs.configuration_color = $(el).find('[name="configuration_color"]:checked').val();
		}else if( step == 'configuration_paper'){
			inputs.configuration_color = $(el).find('[name="configuration_color"]:checked').val();
			inputs.configuration_paper = $(el).find('[name="configuration_paper"]:checked').val();
		}else if( step == 'configuration_ennoblement'){
			inputs.configuration_color = $(el).find('[name="configuration_color"]:checked').val();
			inputs.configuration_paper = $(el).find('[name="configuration_paper"]:checked').val();
			inputs.configuration_ennoblement = $(el).find('[name="configuration_ennoblement"]:checked').val();
		}else{
			inputs = getInputs(true);
			inputs.configuration_art = $('.art input:checked').val();
		}

		Components.loading(el);
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'mp_category_config',
				inputs,
				data,
				params,
			}
		}).done((response) => {
			$('.mp-config-print-options', el).html(response);
			updateSidebar();
			getProducts();
		});
	};

	let requestCustomQuantity = (event) => {
		let inputs = getInputs(true);
		let data = $(el).data();
		let params = $(el).closest('.mp-component').find('input[name="params"]').val();

		Components.loading(el);
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'mp_category_custom_quantitry',
				inputs,
				data,
				params,
			}
		}).done((response) => {
			$('.mp-config-print-prices .mp-prices-table > table', el).append(response);
			updateSidebar();
			Components.loading(el, 'stop');
		});
	};

	let registerEvents = () => {
		function configCampoMedida( campo ) {
			campo.mask(
				"000.00",
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
		configCampoMedida($('[name="sob_medida_width"]',  el));
		configCampoMedida($('[name="sob_medida_height"]', el));

		$('.art [type="radio"]', el).off('change');
		$('.mp-painel mp-painel-body > :not(.art) [type="radio"]', el).off('click');
		$('.mp-config-print-prices [name="product"]', el).off('change');
		$('#mp-custom-quantity-send', el).off('click');
		$('.mp-config-print-options [type="radio"]', el).off('change');
		$('.mp-config-print-options [type="checkbox"]', el).off('change');
		$('#mp-sob-medida-send', el).off('click');
		$('.mp-painel [type="radio"]', el).off('change');

		$('.art [type="radio"]', el).change(getProducts);
		$('.mp-painel mp-painel-body > :not(.art) [type="radio"]', el).click(uncheckRadio);
		$('.mp-config-print-prices [name="product"]', el).change(checkProduct);
		$('#mp-custom-quantity-send', el).click(requestCustomQuantity);
		$('.mp-config-print-options [type="radio"]', el).change(configChanged);
		$('.mp-config-print-options [type="checkbox"]', el).change(configChanged);
		$('#mp-sob-medida-send', el).click(configChanged);
		$('.mp-painel [type="radio"]', el).change(controlActiveSteps);

		// Previne enter no input e quantdade customizada
		$('.mp-custom-quantity input', el).keydown(function (e) {
			if (e.keyCode == 13) {
				$('#mp-custom-quantity-send', el).click();
				e.preventDefault();
				return;

			}

			var validKeys = [
				// Numbers
				'1','2','3','4','5','6','7','8','9','0',
				// Text deletion
				'Backspace','Delete',
				// Text location
				'ArrowLeft', 'ArrowRight', 'Home','End',
			];

			var key = event.key;
			if ( validKeys.includes(key) == false ) {
				console.log("Key \""+key+"\" is a invalid caractere");
				e.preventDefault();
			}
		});
	};

	let checkOptions = () => {
		let all_check = 0;
		$(' .mp-config-print-options .mp-listing', el).each((event, element) => {
			let radios = $(' .mp-checkbox > [type="radio"]', element).length;
			let checked = $(' .mp-checkbox > [type="radio"]:checked', element).length > 0;
			if (radios > 0 && checked) {
				all_check++;
			}

		});

		return all_check >= 4;
	};

	let getProducts = () => {
		$('.mp-gabarito').fadeOut();
		if(checkOptions()) {
			Components.loading(el);
			let inputs = getInputs();
			let productChecked = $("input[name='product']:checked", el).parent();
			let data = $(el).data();
			let params = $(el).closest('.mp-component').find('input[name="params"]').val();
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: 'mp_category_config_prices',
					inputs,
					data,
					params
				}
			}).done((response) => {
				$(' .mp-config-print-prices', el).html(response);
				controlActiveSteps(false);
				registerEvents();
				Components.loading(el, 'stop');
				if ( productChecked.length ) {
					let p = productChecked.find('[name="product"]').val();
					$(' .mp-config-print-prices [name="product"][value="'+p+'"]', el).click();
				}
			});
		} else {
			$(' .mp-config-print-prices', el).html('');
			registerEvents();
			Components.loading(el, 'stop');
		}
	};

	let formSubmit = () => {
		$('.mp-category-config-form [type="submit"]', el).prop("disabled", true);

		let rules = [
			Factory.rule('art', 'Por favor, selecione como deseja enviar sua arte!'),
			Factory.rule('product', 'Por favor, selecione o prazo e a quantidade.'),
		];

		new Form(el, rules, () => {
			Components.loading(el);
			let data = getInputs(true);
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: 'mp_category_config_add',
					data
				}
			}).done((response) => {
				if(response.response) {
					window.location = response.redirect;
				}
			});
		});
	};

	let controlActiveSteps = (event) => {
		updateSidebar();

		let step2 = $('.mp-config-content[data-configuration-step="2"]', el),
			step3 = $('.mp-config-content[data-configuration-step="3"]', el),
			target= $(event.target);

		let editedSteps = $(event.target).parents('.mp-config-content')
		if ( editedSteps.length ) {
			editedSteps.nextAll().removeClass('active');
			if ( editedSteps.nextAll().length ) {
				step3.find('.mp-prices-table').html('')
			}
		}

		if (event) event.stopPropagation();

		if($(' [name="art"]:checked', el).length > 0) {
			step2.addClass('active');
			if ( target.is('[name="art"]:checked') ) {
				$("html, body").animate({ scrollTop: ( checkOptions() ? step3 : step2 ).offset().top }, "slow");
			}
			updateUrl();
		} else {
			step2.removeClass('active');
			step3.removeClass('active');
		}

		if($('.mp-config-print-prices table tbody tr', el).length > 0) {
			step3.addClass('active');
			//$('.mp-category-config-form [type="submit"]', el).prop("disabled", false);
		} else {
			step3.removeClass('active');
		}
	};

	function uncheckRadio() {
		let previousValue = $(this).data('previous-value'),
			name = $(this).data('name');

		if (previousValue === 'checked') {
			$(this).prop('checked', false);
			$(this).data('previous-value', false);
			$(this).change();
		} else {
			$("input[name="+name+"]:radio").data('previous-value', false);
			$(this).data('previous-value', 'checked');
		}
	}

	function checkProduct() {
		let product = $(this).parent('.mp-checkbox');

		let productDescription = product.data('description');
		let descriptionContent = $('.mp-config-sidebar', el).find('.description');

		if ( !productDescription ) {
			descriptionContent.removeClass('active');
		}
		else {
			descriptionContent
				.addClass('active')
				.find('.value')
				.html(product.data('description'));
		}

		if(product.data('sobmedida') != 1) {
			$('.mp-gabarito').fadeIn();
		}
		$('.mp-category-config-form [type="submit"]', el).prop("disabled", false);
	}

	function updateSidebar() {
		let inputs = getInputs();
		let step1 = $('.mp-config-content[data-configuration-step="1"]', el);
		let step2 = $('.mp-config-content[data-configuration-step="2"]', el);
		//let paper_selected = step2.find('.paper input:checked').next();
		let sidebar = $('.mp-config-sidebar', el);
		let config = {
			productName: sidebar.find('.product-name'),
			art: sidebar.find('.art'),
			format: sidebar.find('.format'),
			color: sidebar.find('.color'),
			paper: sidebar.find('.paper'),
			ennoblement: sidebar.find('.ennoblement'),
			finishing: sidebar.find('.finishing'),
		};
		let values = {
			art: step1.find('.art input:checked').attr('data-value'),
			format: step2.find('.format input:checked').val(),
			color: step2.find('.color input:checked').val(),
			paper: step2.find('.paper input:checked').data('value'),
			ennoblement: step2.find('.ennoblement input:checked').data('description'),
			finishing: jQuery.map(
				step2.find('.finishing input:checked'),
				// Pega o texto dos checados
				v => $(v).parent().find('.mp-checkbox-label').text()
			),
		};
		Object.keys(values).forEach(key => {
			if(values[key] === undefined) {
				config[key].removeClass('active');
				return;
			}


			if (key == 'format') {
				if(values[key] != 'custom') {
					config[key].find('.value').html(values[key] +'cm');
				}
				else {

					let width_input = $('.mp-sob-medida [name="sob_medida_width"]', el);
					let height_input = $('.mp-sob-medida [name="sob_medida_height"]', el);
					let medida = width_input.val() + ('x') + height_input.val() + 'cm';

					if (medida == '0.00x0.00cm') {
						config[key].find('.value').html('Insira a medida');

					}
					else {
						config[key].find('.value').html(medida);
					}
				}
			} else if ( key == 'finishing' ) {
				if(values[key].length == 0) {
					config[key].removeClass('active');
					return;
				}
				config[key].find('.value').html('<br>'+values[key].join('<br>'));
			} else if ( key == 'ennoblement' ) {
				if(values[key].length != 0) {
					$('#salvar_favorito').fadeIn();
				}
				config[key].find('.value').html(values[key]);
			} else {
				config[key].find('.value').html(values[key]);
			}

			config[key].addClass('active');
		});

		let productChecked = $("input[name='product']:checked", el).parent();
		if ( productChecked.length ) {
			var valor = $('[name="art"]:checked', el).data("price") ?$('[name="art"]:checked', el).data("price"): 0.0;
			var valorAdic = $('[name="art"]:checked', el).data("adic-price") ?$('[name="art"]:checked', el).data("adic-price"): 0.0;
			let sidebarCustos = sidebar.find('.custos');
			var prod = sidebarCustos.find('.custo_prod');
			var arte = sidebarCustos.find('.custo_arte');
			var final = sidebarCustos.find('.custo_final');
			var custoArte = parseFloat(valor.replace(",","."));
			var custoAdicArte = parseFloat(valorAdic.replace(",","."));
			var custoAdicArte = inputs['modulos'] * custoAdicArte;
			custoArte += custoAdicArte;

			var total = custoArte + inputs['valor'];
			sidebarCustos.css("display","block");
			if(custoArte > 0){
				arte.html("<strong>Arte:</strong> R$"+custoArte.toFixed(2));
			}
			prod.html("<strong>Produto: </strong>R$"+inputs['valor'].toFixed(2));
			final.html("<strong>Total: </strong>R$"+total.toFixed(2));
			sidebar.find('.custos').show();
		}
		else {
			sidebar.find('.description').removeClass('active');
			sidebar.find('.custos').hide();
		}
	}

	function getUrlParams() {
		return {
			'configuration_format': 'formato',
			'configuration_format': 'formato',
			'configuration_color': 'cor',
			'configuration_paper': 'papel',
			'configuration_ennoblement': 'enobrecimento',
			'configuration_finishing': 'acabamento',
			'configuration_art': 'arte',
		};
	}

	function updateUrl( step ) {
		var inputs = {};
		let keysParametros = getUrlParams();
		if($('[name="configuration_format"]:checked').val() == 'custom') {
			inputs.sob_medida_width = $('[name="sob_medida_width"]').val();
			inputs.sob_medida_height = $('[name="sob_medida_height"]').val();
			inputs.configuration_format = "custom";
		}else{
			inputs.configuration_format = $(el).find('[name="configuration_format"]:checked').val();
		}
		if(step == 'configuration_color' || step == 'configuration_format'){
			inputs.configuration_color = $(el).find('[name="configuration_color"]:checked').val();
		}else if( step == 'configuration_paper'){
			inputs.configuration_color = $(el).find('[name="configuration_color"]:checked').val();
			inputs.configuration_paper = $(el).find('[name="configuration_paper"]:checked').val();
		}else if( step == 'configuration_ennoblement'){
			inputs.configuration_color = $(el).find('[name="configuration_color"]:checked').val();
			inputs.configuration_paper = $(el).find('[name="configuration_paper"]:checked').val();
			inputs.configuration_ennoblement = $(el).find('[name="configuration_ennoblement"]:checked').val();
		}else{
			inputs = getInputs();
		}
		inputs.configuration_art = $('.art input:checked').val();

		let inputsFormatadosParametros = {};

			console.log("-------");
			console.log(inputs);
		for (var key in inputs) {
			if ( keysParametros.hasOwnProperty( key ) ) {
				if ( key == 'configuration_finishing' ) {
					inputsFormatadosParametros[ keysParametros[key] ] = inputs[key].join();
				}
				else if ( key == 'configuration_format' && inputs.configuration_format == 'custom') {
					inputsFormatadosParametros[ keysParametros[key] ] = 'custom:'+inputs.sob_medida_width+'x'+inputs.sob_medida_height;
				}
				else {
					inputsFormatadosParametros[ keysParametros[key] ] = inputs[key];
				}
				if(key == step){ break;}
			}
		}

		var str = "";
		for (var key in inputsFormatadosParametros) {
			if (str != "") {
				str += "&";
			}
			str += key + "=" + encodeURIComponent(inputsFormatadosParametros[key]);
		}
		console.log(str);
		window.history.replaceState(inputsFormatadosParametros, '', window.location.pathname + '?' + str);
	}

	registerEvents();
	formSubmit();

	controlActiveSteps(false);

	if ($(window).width() > '768') {
		new StickSidebar($('.mp-config-sidebar .sidebar-inner', el));
	}

}
