import Form from "../Form";
import Components from "../Components";

export default function (el) {
	let panel = $(el);
	let tableAddr = panel.find('table.addresses tbody');
	let form = $('#save-address');
	let addAddr = $('#add-address');
	let action = '';
	let message = $('.address-message');
	let rules = [
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
	];
	let loadAddresses = function() {
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'mp_get_addresses',
				data: {},
			}
		}).done((response) => {
			tableAddr.html('');
			for(let i in response) {
				let row = $(`
				<tr>
					<td>${response[i].rua}, ${response[i].numero} ${response[i].complemento ? response[i].complemento : ''} - ${response[i].bairro} <br><strong>CEP: </strong>${response[i].cep}</td>
					<td>${response[i].telefone}</td>
					<td class="actions">
						<a href="#" class="edit" title="Editar"><i class="fai fa-edit"></i></a>
						<a href="#" class="remove" title="Remover"><i class="fai fa-remove"></i></a>
					</td>
				</tr>`);
				row.data('address', response[i]);
				tableAddr.append(row);
			}
		});
	};
	loadAddresses();

	Form.cep(el);

	$('#cep').mask('00000-000');
	$('#telefone').mask('(00) 00000-0000');

	new Form(el, rules, form => {
		Components.loading(el);
		let data = form.serializeArray();
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action,
				data,
			}
		}).done((res) => {
			console.log(res);
			Components.loading(el, 'stop');
			setTimeout(loadAddresses, 1000);
			form.hide();
			message.removeClass('hidden');
			message.find('.flash-body').html('O endereço foi salvo');
			$("html, body").animate({ scrollTop: 0 }, 500);
		});
	});
	addAddr.on('click', e => {
		e.preventDefault();
		form.show();
		action = 'mp_save_address';
	});
	tableAddr.on('click', '.edit', e => {
		e.preventDefault();
		form.show();
		action = 'mp_edit_address';
		let row = $(e.currentTarget).closest('tr');
		let data = row.data('address');
		$('#id').val(data.id);
		$('#cep').val(data.cep);
		$('#estado').val(data.estado);
		$('#cidade').val(data.cidade);
		$('#bairro').val(data.bairro);
		$('#rua').val(data.rua);
		$('#numero').val(data.numero);
		$('#telefone').val(data.telefone);
		$('#complemento').val(data.complemento);
	});
	tableAddr.on('click', '.remove', e => {
		e.preventDefault();
		let row = $(e.currentTarget).closest('tr');
		let data = row.data('address');
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'mp_remove_address',
				data: {
					codigoEnd: data.id
				},
			}
		}).done((response) => {
			if(response === true) {
				row.remove();
				message.removeClass('hidden');
				message.find('.flash-body').html('O endereço foi removido');
			}
		});
	});

	$('.mp-flash').on('click', '.close', e => {
		e.preventDefault();
		$(e.currentTarget).closest('.mp-flash').addClass('hidden');
	});
}
