import Components from '../Components';
import Form from '../Form'

export default function (el) {
	var rules = [
		{
			'name': 'email-incomplete-register-social',
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
			'name': 'confirm-email-incomplete-register-social',
			'rules': {
				stop: true,
				title: 'E-mail',
				equal: {
					value: '',
					field: 'Confirmaçao de e-mail',
					select: '[name="email-incomplete-register-social"]',
					message: '{field} invalida!'
				}
			}
		},
		{
			'name': 'nome-completo-incomplete-register-social',
			'rules': {
				stop: true,
				required: {
					message: 'O nome é obrigatorio!',
				}
			}
		},
	];

	var getInputs = () => {

		var values = {};
		$(' input, select', el).each((event, element) => {
			values[$(element).attr('name')] = $(element).val();
		});
		return values;
	};

	var registerEvents = () => {
		$('input[name="celular-incomplete-register-social"]').mask('(00) 00000-0000');
		new Form(el, rules, (form) => {
			Components.loading(el);

			var inputs = getInputs();
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: 'mp_incomplete_register_social',
					'data': inputs,
					'params': inputs.params,
				}
			}).done((response) => {
				if (typeof response.redirect != 'undefined') {
					window.location = response.redirect;
					return;
				}

				$(el).html(response);
				registerEvents();

				Components.loading(el, 'stop');
			});
		});
	}

	registerEvents();

}
