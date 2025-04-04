import Components from "./Components";

import customValidations from './Form.validations';

export default class Form {
	constructor(el, rules, callback) {
		this.form = $(el).find('form').first();
		this.rules = rules;
		this.approve = require('approvejs');
		this.errors = [];
		this.scroolToError = true;

		this.form.submit(() => {
			var submit = false;
			this.scroolToError = true;
			if (this.validation()) {
				if(typeof callback === 'function') {
					if(this.form.data('callback') === false) {
						submit = true;
					} else {
						callback(this.form);
					}
				} else {
					submit =  true;
				}
			}
			return submit;
		});

		/*this.form.on('keyup', 'input, select, textarea', () => {
			this.scroolToError = false;
			this.validation()
		});*/

		for (var key in customValidations) {
			this.approve.addTest(customValidations[key], key)
		}

		if ( this.form.find('.mp-errors label.mp-error').length ) {
			this.scrollToErrors();
		}
		this.changeClass();
	}

	validation() {

		if(this.form.data('validation') == 'validated') {
			return true;
		}

		this.errors = [];
		this.rules.forEach((rule, index) => {
			this.validate(rule);
		});

		this.form.find('.mp-required').each((key,value) => {
			if($(value).is('input')) {
				this.validate({
					'name': $(value).attr('name'),
					'rules': {
						required: {
							message: 'Preencha todos os campos obrigatorios.',
						}
					}
				});
			}
		});

		this.showErrors();
		this.changeClass();
		if (this.errors.length == 0) {
			return true;
		}
		return false;
	}

	validate(rule) {
		if(this.checkIfFieldIsValid(rule)) {
			if(this.form.find('[name="'+rule.name+'"]:visible').attr('type') == 'radio') {
				var val = this.form.find('[name="'+rule.name+'"]:visible:checked').val();
			} else {
				var val = this.form.find('[name="'+rule.name+'"]').val();
			}

			if("equal" in rule.rules) {
				rule.rules.equal.value = this.form.find(rule.rules.equal.select).val()
			}

			var result = this.approve.value(val, rule.rules);
			if (!result.approved) {
				this.errors.push({
					'name': rule.name,
					'errors': result.errors
				});
			}
		}
	}

	static revalidate(){
		$(document).on('keyup', '[data-error] input',  function(){
		    $(this).parent().attr('data-error', '');
		    $(this).css('background','#fff');
		    $(this).css('border-color','');
		});
	}

	showErrors() {
		if(!this.hasErrors()) {
			this.form.find('.mp-errors').fadeOut(200, () => {
				this.form.find('.mp-errors').remove();
			});
			return;
		}
		var html = '';
		this.errors.forEach((error) => {
			var element = document.querySelector('[name='+error.name+']');
			if(
				element.tagName == 'SELECT' 
				|| element.getAttribute('type') == 'text'
				|| element.getAttribute('type') == 'email'
				|| element.getAttribute('type') == 'password'
			){
				$('[name='+error.name+']').parent().attr('data-error', error.errors[0]);
				element.style.backgroundColor = "#ffeeee";
				element.style.borderColor = "#ff0000";
			}else if(element.getAttribute('type') == 'radio'){
				$('[name='+error.name+']').parent().parent().attr('data-error', error.errors[0]);
			}
		});
	}

	scrollToErrors() {
		if ( this.scroolToError == false ) {
			return
		}
		$("html, body").animate({ scrollTop: this.form.find('.mp-errors').offset().top-45 }, "slow");
	}

	hasErrors() {
		return this.errors.length > 0;
	}

	checkIfFieldIsValid(rule) {
		const field = this.form.find('[name="'+rule.name+'"]');

		if(field.is('[type="hidden"]')) {
			return true;
		}

		if(!field.is(':visible')) {
			return false;
		}

		return true;
	}

	changeClass() {
		this.form.removeClass('mp-form-valid').removeClass('mp-form-invalid').addClass(this.hasErrors() ? 'mp-form-invalid':'mp-form-valid');
	}

	static loadCpf(el){
		// Autocompletar com CEP
		$('#cpf').on('keyup', () => {
			let cpf = $('#cpf').val().replace(/\W/g, '');
			let data_nasc = $('[name="nascimento"]').val();
			if(cpf.length !== 11 || data_nasc == "") {return;}
			Components.loading(el);
			$.get("https://ws.hubdodesenvolvedor.com.br/v2/cpf/?cpf="+cpf+"&data="+data_nasc+"&token=75685795ivyeMakhLI136648408", 
				(resposta) => {
					Components.loading(el, 'stop');
					if(
						resposta.result != undefined && 
						(resposta.result.situacao_cadastral == "REGULAR" || resposta.result.situacao_cadastral == "PENDENTE DE REGULARIZAÇÃO")
					){
						let nomeCompleto = resposta.result.nome_da_pf;
						let partesDoNome = nomeCompleto.split(' ');
						$('[name="customers_social_name"]').val(partesDoNome[0]);
						$('[name="nome-completo"]').val(resposta.result.nome_da_pf);
						$('[name="cpf"]').css('background', '#fff');
						$('[name="cpf"]').css('border-color', '');
						$('[name="nome-completo"]').css('background', '#e0dede');
						$('[name="nome-completo"]').css('border-color', '');
						$('[name="cpf"]').parent().attr('data-error', "");
						return true;
					}else{
						console.log(resposta);
						$('[name="cpf"]').val('');
						$('[name="cpf"]').css('background', '#ffeeee');
						$('[name="cpf"]').css('border-color', 'red');
						$('[name="cpf"]').parent().attr('data-error', "CPF inválido");
						return false;
					}
					
				}
			);
		});
	}

	static loadCnpj(el){
		// Autocompletar com CEP
		$('#cnpj').on('keyup', () => {
			let cnpj = $('#cnpj').val().replace(/\W/g, '');
			if(cnpj.length !== 14) {
				return;
			}
			Components.loading(el);
			$.get("https://ws.hubdodesenvolvedor.com.br/v2/cnpj/?cnpj="+cnpj+"&token=75685795ivyeMakhLI136648408", 
				(resposta) => {
					Components.loading(el, 'stop');
					if(resposta.result != undefined && resposta.result.situacao == "ATIVA"){
						/*preenchendo campos*/
						$('[name="razao-social"]').val(resposta.result.nome);
						$('[name="ativ_principal_text"]').val(resposta.result.atividade_principal.text);
						$('[name="ativ_principal_code"]').val(resposta.result.atividade_principal.code);
						if(resposta.result.atividades_secundarias){
							$('[name="ativ_sec1_text"]').val(resposta.result.atividades_secundarias[0].text);
							$('[name="ativ_sec1_code"]').val(resposta.result.atividades_secundarias[0].code);
							if(resposta.result.atividades_secundarias[1]){
								$('[name="ativ_sec2_text"]').val(resposta.result.atividades_secundarias[1].text);
								$('[name="ativ_sec2_code"]').val(resposta.result.atividades_secundarias[1].code);
							}
						}
						/*limpando campos vermelhos*/
						$('[name="cnpj"]').css('background', '#fff');
						$('[name="cnpj"]').css('border-color', '');
						$('[name="razao-social"]').css('background', '#e0dede');
						$('[name="razao-social"]').css('border-color', '');
						$('[name="cnpj"]').parent().attr('data-error', "");
						return true;
					}else{
						console.log(resposta);
						$('[name="cnpj"]').val('');
						$('[name="cnpj"]').css('background', '#ffeeee');
						$('[name="cnpj"]').css('border-color', 'red');
						$('[name="cnpj"]').parent().attr('data-error', "CNPJ inválido");
						return false;
					}
					
				}
			);
		});
	}
	

	static cep(el) {
		// Autocompletar com CEP
		$('#cep').on('keyup', function () {
			let cep = this.value.replace(/\W/g, '');
			if(cep.length !== 8) {
				return;
			}
			Components.loading(el);
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: 'mp_cep',
					data: {
						cep,
					},
				}
			}).done(data => {
				Components.loading(el, 'stop');
				$('#estado').val(data.uf);
				$('#cidade').val(data.localidade);
				$('#bairro').val(data.bairro);
				$('#rua').val(data.logradouro);
			});
		});

	}
}
