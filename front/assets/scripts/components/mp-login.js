import Components from '../Components';
import Form from '../Form'

export default function (el) {
	var rules = [
		{
			'name': 'email-incomplete-register',
			'rules': {
				stop: true,
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
					message: 'O celular é obrigatório!',
				},
				minLength: {
					value: 15,
					message: 'O celular deve ter pelo menos 15 caracteres!',
				}
			}
		},
	];

	var getInputs = () => {
		var values = {};
		$(' input, select', el).each((index, element) => {
			values[$(element).attr('name')] = $(element).val();
		});
		return values;
	};

	var registerEvents = () => {
		$('input[name="celular-incomplete-register"]').mask('(00) 00000-0000');
		new Form(el, rules, (form) => {
			Components.loading(el);

			var inputs = getInputs();
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: 'mp_incomplete_register',
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
