import Form from '../Form'
import Components from '../Components';

export default function (el) {
	new Form(el, [{
		'name': 'email',
		'rules': {
			stop: true,
			required: {
				message: 'E-mail é obrigatório!',
			},
			email: {
				message: 'E-mail inválido',
			}
		}
	}], (form) => {
		Components.loading(el);
		var email = form.find('[name="email"]').val();

		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'mp_newsletter',
				email: email,
			}
		}).done((response) => {
			Components.loading(el, 'stop');
			el.html(response);
		});
	});
}
