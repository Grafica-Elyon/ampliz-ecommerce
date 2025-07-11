import Form from "../Form";
import Components from "../Components";

export default function (el) {
	var ruleRequired = function (inputName, message) {
		return {
			'name': inputName,
			'rules': {
				stop: true,
				required: {
					message: message,
				}
			}
		};
	};
	var url = window.location.href;
	var params = {};
	var parser = document.createElement('a');
	parser.href = url;
	var query = parser.search.substring(1);
	var vars = query.split('&');
	for (var i = 0; i < vars.length; i++) {
		var pair = vars[i].split('=');
		params[pair[0]] = decodeURIComponent(pair[1]);
	}
	let fields = {
		name: $('#name'),
		customers_social_name: $('#customers_social_name'),
		email: $('#email'),
		telephone: $('#telephone'),
		celular: $('#celular'),
		cpf: $('#cpf'),
		cnpj: $('#cnpj'),
		razao_social: $('#razao-social'),
		nascimento: $('#nascimento'),
		sexo: $('[name="sexo"]'),
		role: $('#role'),
		cep: $('#cep'),
		state: $('#state'),
		city: $('#city'),
		neighborhood: $('#neighborhood'),
		street: $('#street'),
		complement: $('#complement'),
		number: $('#number'),
		password: $('#password'),
		confirm_password: $('#confirm_password'),
		info_uso: $('[name="info-uso"]'),
		ativ_principal_text: $('[name="ativ_principal_text"]'),
		ativ_principal_code: $('[name="ativ_principal_code"]'),
		ativ_sec1_text: $('[name="ativ_sec1_text"]'),
		ativ_sec1_code: $('[name="ativ_sec1_code"]'),
		ativ_sec2_text: $('[name="ativ_sec2_text"]'),
		ativ_sec2_code: $('[name="ativ_sec2_code"]'),
		emitir_nota_como: $('[name="emitir_nota_como"]'),
		info_referer: $('[name="info_referer"]'),
		ocupacao: $('[name="ocupacao"]'),
		area_atuacao: $('[name="area_atuacao"]'),
		departamento: $('[name="departamento"]'),
		cargo: $('[name="cargo"]'),
	};
	let rules = [
		{
			'name': 'name',
			'rules': {
				stop: true,
				required: {
					message: 'o nome é obrigatório!',
				}
			}
		},
		{
			'name': 'cpf',
			'rules': {
				stop: true,
				required: {
					message: 'o cpf é obrigatório!',
				}
			}
		},
		{
			'name': 'confirm_password',
			'rules': {
				stop: true,
				equal: {
					value: '',
					field: 'Confirmação de senha',
					select: '[name="password"]',
					message: 'a senha não está confirmando!',
				}
			}
		},
		{
			'name': 'street',
			'rules': {
				stop: true,
				required: {
					message: 'o endereço é obrigatório!',
				}
			}
		},
		{
			'name': 'number',
			'rules': {
				stop: true,
				required: {
					message: 'o numero é obrigatório!',
				}
			}
		},
		{
			'name': 'cep',
			'rules': {
				stop: true,
				required: {
					message: 'o cep é obrigatório!',
				}
			}
		},
		{
			'name': 'neighborhood',
			'rules': {
				stop: true,
				required: {
					message: 'o bairro é obrigatório!',
				}
			}
		},
		{
			'name': 'city',
			'rules': {
				stop: true,
				required: {
					message: 'a cidade é obrigatória!',
				}
			}
		},
		{
			'name': 'state',
			'rules': {
				stop: true,
				required: {
					message: 'o estado é obrigatório!',
				}
			}
		},
		{
			'name': 'nascimento',
			'rules': {
				stop: true,
				required: {
					message: 'a data de nascimento é obrigatória!',
				},
				'valid-date': {
					start: (new Date).toJSON().replace(/T.*$/, '').split('-').reverse().join('/'),
					end: '01/01/1900',
					format: (value) => {
						return value.replace(/^(\d{2})\/(\d{2})\/(\d{4}).*/, '$3-$2-$1') + 'T12:00:00-0300'
					},
					message: 'a data de nascimento deve estar entre hoje e o ano de 1900!',
				}
			}
		},
		{
			'name': 'ocupacao',
			'rules': {
				stop: true,
				required: {
					message: 'O campo ocupação é obrigatório!',
				}
			}
		},
		{
			'name': 'area_atuacao',
			'rules': {
				stop: true,
				required: {
					message: 'O campo área de atuação é obrigatório!',
				}
			}
		},
		{
			'name': 'cargo',
			'rules': {
				stop: true,
				required: {
					message: 'O campo cargo é obrigatório!',
				}
			}
		},
		{
			'name': 'departamento',
			'rules': {
				stop: true,
				required: {
					message: 'O Departamento é obrigatório!',
				}
			}
		},
	];
	let message = $('.data-message');
	$.ajax({
		method: "POST",
		url: wp.ajax_url,
		data: {
			action: 'mp_get_user_data',
			data: {},
		}
	}).done((response) => {
		if (verificarSePessoaJuridica(response.dadosCliente.customers_cnpj)) {
			$('.cnpj-fields', el).show();
			$('.cpf-fields', el).hide();
			rules.push((() => {
				let rule = ruleRequired('cnpj', 'CNPJ é obrigatório');
				rule.rules['cnpj'] = {
					message: 'CNPJ digitado é inválido',
				};
				rule.rules['min'] = {
					min: 17,
					message: 'CNPJ digitado incompleto',
				};
				return rule;
			})());

			rules = rules.filter(e => {
				return [
					'ocupacao',
					'area_atuacao',
				].indexOf(e.name) === -1;
			});

			rules.push(ruleRequired('razao-social', 'A razão social é obrigatória!'));
			rules.push(ruleRequired('cargo', 'Cargo é obrigatório!'));
			rules.push(ruleRequired('departamento', 'Departamento é obrigatório!'));
			rules.push(ruleRequired('ramo-atividade', 'O Ramo de atividade é obrigatório!'));
			fields.departamento.val(response.dadosCliente.company_department_id);
			fields.cargo.val(response.dadosCliente.company_position_id);
		} else {
			$('.cnpj-fields', el).hide();
			$('.cpf-fields', el).show();
			rules = rules.filter(e => {
				return [
					'cnpj',
					'razao-social',
					'cargo',
					'departamento'
				].indexOf(e.name) === -1;
			});
			rules.push(ruleRequired('ocupacao', 'A Ocupação é obrigatória!'));
			rules.push(ruleRequired('area_atuacao', 'A Área de atuação é obrigatória!'));
			fields.ocupacao.val(response.dadosCliente.customers_occupation);
			fields.area_atuacao.val(response.dadosCliente.customers_activity);

		}
		fields.name.val(response.dadosCliente.customers_firstname);
		fields.customers_social_name.val(response.dadosCliente.customers_social_name);
		fields.email.val(response.dadosCliente.customers_email_address);
		fields.telephone.val(response.dadosCliente.customers_telephone);
		fields.celular.val(response.dadosCliente.customers_celular);
		fields.cpf.val(response.dadosCliente.customers_cpf);
		fields.razao_social.val(response.dadosCliente.customers_company);
		fields.nascimento.val(
			response.dadosCliente.customers_dob == '0000-00-00 00:00:00' ?
				'' :
				response.dadosCliente.customers_dob.replace(/^(\d{4})-(\d{2})-(\d{2}).*/, '$3/$2/$1')
		);
		fields.cnpj.val(response.dadosCliente.customers_cnpj);
		fields.cep.val(response.dadosEndereco.entry_postcode);
		fields.state.val(response.dadosEndereco.entry_state);
		fields.city.val(response.dadosEndereco.entry_city);
		fields.neighborhood.val(response.dadosEndereco.entry_suburb);
		fields.street.val(response.dadosEndereco.entry_street_address);
		fields.number.val(response.dadosEndereco.entry_street_number);
		fields.complement.val(response.dadosEndereco.complement);
		fields.info_uso.val(response.dadosCliente.customers_final);
		fields.info_referer.val(response.dadosCliente.customers_conheceu);

		fields.emitir_nota_como.each(function () {
			if (this.getAttribute('use') == "cnpj") {
				this.value = response.dadosCliente.customers_cnpj;
			} else {
				this.value = response.dadosCliente.customers_cpf;
			}
			if (this.value == response.dadosCliente.customers_cpf_cnpj) {
				$(this).prop('checked', true);
			}
		});
		fields.sexo.each(function () {
			if (this.value.toUpperCase() == response.dadosCliente.customers_gender.toUpperCase()) {
				$(this).prop('checked', true);
			}
		});

		// Caso os selects não estejam com valores válidos, ele os limpa
		Object.keys(fields).forEach(function (key) {
			var field = fields[key];
			if (field.is('select')) {
				if (field.find(':selected').length == 0) {
					field.val("");
				}
			}
		})
		fields.cep.mask('00000-000');
		fields.cnpj.mask('00.000.000/0000-00');
		fields.telephone.mask('(00) 0000-00000');
		fields.celular.mask('(00) 00000-00000');
		fields.nascimento.mask('00/00/0000');
		fields.cpf.mask('000.000.000-00');
	});

	var registerEvents = () => {
		new Form(el, rules, form => {
			Components.loading(el);
			let data = form.serializeArray();
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: 'mp_get_edit_user_data',
					data,
				}
			}).done((response) => {
				if (response.body.response == "error") {
					$("html, body").animate({ scrollTop: 0 }, "slow");
					let error = $('.mp-error');
					error.find('.flash-body').html(response.body.message);
					error.removeClass('hidden');
					setTimeout(function () {
						error.addClass('hidden');
					}, 5000);
					Components.loading(el, 'stop');
					return;
				}
				registerEvents();
				Components.loading(el, 'stop');
				message.removeClass('hidden');
				if (params.redirect) {
					message.find('.flash-body').html('Seus dados foram salvos. Redirecionando...');
					setTimeout(function () {
						window.location.href = params.redirect
					}, 3000);
				}
				else {
					message.find('.flash-body').html('Seus dados foram salvos');
				}
				$("html, body").animate({ scrollTop: 0 }, "slow");
			});
		});

		Form.cep(el);
		Form.loadCpf(el);
		Form.loadCnpj(el);
		Form.revalidate();
	};

	$('.mp-flash').on('click', '.close', e => {
		e.preventDefault();
		$(e.currentTarget).closest('.mp-flash').addClass('hidden');
	});

	function verificarSePessoaJuridica(cnpj) {
		if (cnpj === null || cnpj === "") {
			return false; // Retorna fasle se for null ou Vazio
		} else {
			return true; // Retorna true se tiver um valor
		}
	}

	registerEvents();
}
