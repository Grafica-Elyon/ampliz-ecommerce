import Components from '../Components';
import Form from '../Form'

export default function (el) {
    console.log('Iniciando a função com o elemento:', el);

	// Identificando qual formulário está sendo manipulado
	const isRegisterStep1 = $(el).hasClass('register-step1');
	const isRegisterStep2 = $(el).hasClass('register-step2');
	const isLoginForm = $(el).hasClass('login-form');

    console.log('Formulário identificado:', {
        isRegisterStep1,
        isRegisterStep2,
        isLoginForm
    });
	// Regras para a primeira tela do registro (email e telefone)
	const registerStep1Rules = [
		{
			'name': 'email-incomplete-register',
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
			'name': 'celular-incomplete-register',
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
			'name': 'email-login',
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
			'name': 'password-login',
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
        console.log('Valores coletados dos inputs:', values);
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

        console.log('Regras de validação selecionadas:', rules);

		new Form(el, rules, (form) => {
            console.log('Formulário validado, iniciando o carregamento...');

			Components.loading(el);

			const inputs = getInputs();
			let action = isLoginForm ? 'mp_login' : 'mp_incomplete_register';
            console.log('Enviando dados via AJAX com a ação:', action, 'e dados:', inputs);

			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: action,
					'data': inputs,
					'params': inputs.params,
				}
			}).done((response) => {
                console.log('Resposta recebida:', response);

				if (typeof response.error !== 'undefined') {
					const errorContainer = $(el).find('.error-message');
					errorContainer.html(response.error).show();
                    console.log('Erro encontrado:', response.error);
					Components.loading(el, 'stop');
					return;
				}

				if (typeof response.redirect !== 'undefined') {
                    console.log('Redirecionando para:', response.redirect);
					window.location = response.redirect;
					return;
				}

				$(el).html(response);
                console.log('Atualizando o formulário com a resposta recebida.');
				registerEvents();

				Components.loading(el, 'stop');
			}).fail((jqXHR, textStatus, errorThrown) => {
				const errorContainer = $(el).find('.error-message');
				errorContainer.html('Ocorreu um erro. Por favor, tente novamente.').show();
                console.error('Erro na requisição AJAX:', textStatus, errorThrown);
				Components.loading(el, 'stop');
			});
		});
	}

	registerEvents();
}