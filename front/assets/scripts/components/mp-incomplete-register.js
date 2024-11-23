import Components from '../Components';
import Form from '../Form'

export default function (el) {
	// Identificando qual formulário está sendo manipulado
	const isRegisterStep1 = $(el).hasClass('register-step1');
	const isRegisterStep2 = $(el).hasClass('register-step2');
	const isLoginForm = $(el).hasClass('login-form');

	// Regras para a primeira tela do registro (email e telefone)
	const registerStep1Rules = [
		{
			'name': 'email',
			'rules': {
				stop: false,
				required: {
					message: 'E-mail é obrigatório!',
				},
				email: {
					message: 'E-mail inválido',
				}
			}
		},
		{
			'name': 'telefone',
			'rules': {
				stop: true,
				required: {
					message: 'Telefone é obrigatório!',
				}
			}
		}
	];

	// Regras para o segundo passo do registro
	const registerStep2Rules = [
		{
			'name': 'nome-completo',
			'rules': {
				stop: true,
				required: {
					message: 'O nome é obrigatório!',
				}
			}
		},
		// Adicione outras regras para os campos do segundo passo aqui
	];

	const loginRules = [
		{
			'name': 'email',
			'rules': {
				stop: false,
				required: {
					message: 'E-mail é obrigatório!',
				},
				email: {
					message: 'E-mail inválido',
				}
			}
		},
		{
			'name': 'senha',
			'rules': {
				stop: true,
				required: {
					message: 'A senha é obrigatória!',
				}
			}
		}
	];

	const getInputs = () => {
		const values = {};
		$('input, select', el).each((event, element) => {
			values[$(element).attr('name')] = $(element).val();
		});

		if (isRegisterStep1) {
			values.form_type = 'register_step1';
		} else if (isRegisterStep2) {
			values.form_type = 'register_step2';
		} else if (isLoginForm) {
			values.form_type = 'login';
		}

		return values;
	};

	const registerEvents = () => {
		let rules;
		if (isRegisterStep1) {
			rules = registerStep1Rules;
		} else if (isRegisterStep2) {
			rules = registerStep2Rules;
		} else if (isLoginForm) {
			rules = loginRules;
		}

		new Form(el, rules, (form) => {
			Components.loading(el);

			const inputs = getInputs();
			let action = isLoginForm ? 'mp_login' : 'mp_incomplete_register';

			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: action,
					'data': inputs,
					'params': inputs.params,
				}
			}).done((response) => {
				if (typeof response.error !== 'undefined') {
					const errorContainer = $(el).find('.error-message');
					errorContainer.html(response.error).show();
					Components.loading(el, 'stop');
					return;
				}

				if (typeof response.redirect !== 'undefined') {
					window.location = response.redirect;
					return;
				}

				$(el).html(response);
				registerEvents();

				Components.loading(el, 'stop');
			}).fail((jqXHR, textStatus, errorThrown) => {
				const errorContainer = $(el).find('.error-message');
				errorContainer.html('Ocorreu um erro. Por favor, tente novamente.').show();
				Components.loading(el, 'stop');
			});
		});
	}

	registerEvents();
}