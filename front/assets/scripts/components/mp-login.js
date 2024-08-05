import Components from '../Components';
import Form from '../Form'

export default function (el) {
	var rules = [
		{
			'name': 'email',
			'rules': {
				stop: true,
				required: {
					message: 'E-mail é obrigatório!',
				}
			}
		},
		{
			'name': 'password',
			'rules': {
				stop: true,
				required: {
					message: 'A senha é obrigatoria!',
				}
			}
		},
	];

	// Opções de Impressão
	var getInputs = () => {

		var values = {};
		$(' input', el).each((event, element) => {
			values[$(element).attr('name')] = $(element).val();
		});

		return values;
	};

	var registerEvents = () => {
		new Form(el, rules, (form) => {
			Components.loading(el);

			let inputs = getInputs();

			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: inputs.action || 'mp_login',
					'data': getInputs(),
					'params': $(' [name="params"]', el).val()
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
