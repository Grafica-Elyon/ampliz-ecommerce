import Form from "../Form";
import Components from "../Components";

// Verificar se $_SESSION['userData']['id'] está vazio ou nulo
//var isUserIdEmpty = !Boolean($_SESSION['userData']['id']);

export default function (el) {
	var ruleRequired = function( inputName, message ) {		
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
	var rules = [
		ruleRequired( 'nome-completo', 'O nome é obrigatório!' ),
		ruleRequired( 'customers_lastname', 'O nickname é obrigatório!' ),
		ruleRequired( 'celular', 'O celular é obrigatório!' ),
		ruleRequired( 'genero', 'O genero é obrigatório!' ),
		ruleRequired( 'logradouro', 'O endereço é obrigatório!' ),
		ruleRequired( 'numero', 'O numero é obrigatório!' ),
		ruleRequired( 'cep', 'O cep é obrigatório!' ),
		ruleRequired( 'bairro', 'O bairro é obrigatório!' ),
		ruleRequired( 'cidade', 'A cidade é obrigatória!' ),
		ruleRequired( 'info-referer', '"Onde nos conheceu?" é obrigatório!' ),
		ruleRequired( 'estado', 'O estado é obrigatório!' ),
		ruleRequired( 'nascimento', 'A data de nascimento é obrigatória!' ),
		(() => {
			let rule = ruleRequired( 'cpf', 'O CPF é obrigatório' )
			rule.rules['cpf'] = {
				message: 'CPF digitado é inválido',
			};
			rule.rules['min'] = {
					min:14,
					message: 'CPF digitado incompleto',
				};
			return rule;
		})(),
		{
			'name': 'email',
			'rules': { 
				stop: false,
				required: {
					message: 'E-mail é obrigatórioooooo!',
				},
				email: {
					message: 'E-mail inválido',
				}
			}
		},
		{
			'name': 'confirm-email',
			'rules': {
				stop: true,
				title: 'E-mail',
				equal: {
					value: '',
					field: 'Confirmaçao de e-mail',
					select: '[name="email"]',
					message: '{field} invalida!'
				}
			}
		},
		//ruleRequired( 'password', 'A senha é obrigatória!' ),
		//isUserIdEmpty ? ruleRequired('password', 'A senha é obrigatória!') : null,
		{
			'name': 'confirm-password',
			'rules': {
				stop: true,
				title: 'Senha',
				equal: {
					value: '',
					field: 'Confirmaçao de senha',
					select: '[name="password"]',
					message: '{field} invalida!'
				},
			}
		},
	];
	if(window.location.host.indexOf("mrprint") !== -1){
		let rulesFranquias = [
			ruleRequired( 'profissao', 'A profissão é obrigatória!' ),
			ruleRequired( 'areainteresse', 'A área de interesse é obrigatória' ),
			ruleRequired( 'info-uso', 'Finalidade de uso obrigatória!' ),
			ruleRequired( 'area-atuacao', 'A Área é obrigatória!' ),
			ruleRequired( 'info-software', 'Programa é obrigatório!' ),
			ruleRequired( 'info-faturamento', 'Faturamento com gráficas mensal obrigatório!' ),
			ruleRequired( 'info-loja-fisica', 'Campo "Loja física" é obrigatório!' ),
			ruleRequired( 'info-funcionarios', 'Quantidade de funcionários obrigatório!' )
		];
		rules = rules.concat(rulesFranquias);
	}

	var getInputs = () => {
		var values = {};
		$(' input, select', el).each((event, element) => {
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

	var registerEvents = () => {
		$('input[name="cep"]').mask('00000-000');
		$('input[name="cpf"]').mask('000.000.000-00');
		$('input[name="cnpj"]').mask('00.000.000/0000-00');
		$('input[name="telefone"]').mask('(00) 00000-0000');
		$('input[name="celular"]').mask('(00) 00000-0000');
		$('input[name="nascimento"]').mask('99/99/9999');
		new Form(el, rules, (form) => {
			Components.loading(el);
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: 'mp_register',
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
		Form.cep(el);
		Form.loadCpf(el);
		Form.loadCnpj(el);
		Form.revalidate();
		changeCnpf();
	};

	let changeCnpf = () => {
		let radios = $('[name="pessoa"]', el);
		radios.on('change', e => {
			let r = $(e.currentTarget);
			if(r.val() === 'Pessoa Jurídica') {
				$('.cnpj-fields', el).show(); 
				rules.push((() => {
							let rule = ruleRequired( 'cnpj', 'CNPJ é obrigatório' );
							rule.rules['cnpj'] = {
								message: 'CNPJ digitado é inválido',
							};
							rule.rules['min'] = {
								min:17,
								message: 'CNPJ digitado incompleto',
							};
							return rule;
						})());

				rules.push(ruleRequired( 'razao-social', 'A razão social é obrigatória!' ));
			} else {
				$('.cnpj-fields', el).hide();
				rules = rules.filter( e => {
					return [
						'cnpj',
						'razao-social',
					].indexOf(e.name) === -1;
				});
			}
		})
	}

	registerEvents();

	
}
