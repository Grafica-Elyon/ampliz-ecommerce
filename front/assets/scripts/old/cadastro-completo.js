var amplizApiBase = (function(){
	var defaultUrl = (typeof window !== 'undefined' && window.location && window.location.origin) ? window.location.origin : '';
	if (typeof window !== 'undefined' && window.MrPrint && window.MrPrint.apiUrl) {
		defaultUrl = window.MrPrint.apiUrl;
	}

	return defaultUrl.replace(/\/$/, '');
})();
var amplizAuthorizationToken = (typeof window !== 'undefined' && window.MrPrint && window.MrPrint.authorizationToken)
	? window.MrPrint.authorizationToken
	: '';
(function ($) {
	window.CadastroCompleto = {
		cadastro: $('.cadastro'),
		fomulario: $('#cadastro-completo'),
		init: function () {
			CadastroCompleto.verificarCadastro();
		},
		salvarCadastro: function () {

			CadastroCompleto.loadingShow();
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action                          : 'cadastro_completo',
					expects                         : 'add',
					customers_firstname             : CadastroCompleto.fomulario.find('input[name="cliente-nome"]').val(),
					customers_dob                   : CadastroCompleto.fomulario.find('input[name="cliente-dob"]').val(),
					customers_email_address         : CadastroCompleto.fomulario.find('input[name="cliente-email"]').val(),
					customers_password              : CadastroCompleto.fomulario.find('input[name="cliente-password"]').val(),
					customers_agree                 : CadastroCompleto.fomulario.find('input[name="cliente-agree"]').val(),
					customers_telephone             : CadastroCompleto.fomulario.find('input[name="cliente-telefone"]').val(),
					customers_celular               : CadastroCompleto.fomulario.find('input[name="cliente-celular"]').val(),
					aparelho                        : CadastroCompleto.fomulario.find('input[name="comunicacao-aparelho"]').val(),
					operadora                       : CadastroCompleto.fomulario.find('input[name="comunicacao-operadora"]').val(),
					skype                           : CadastroCompleto.fomulario.find('input[name="comunicacao-skype"]').val(),
					facebook                        : CadastroCompleto.fomulario.find('input[name="comunicacao-facebook"]').val(),
					twitter                         : CadastroCompleto.fomulario.find('input[name="comunicacao-twitter"]').val(),
					entry_postcode                  : CadastroCompleto.fomulario.find('input[name="endereco-postcode"]').val(),
					entry_street_address            : CadastroCompleto.fomulario.find('input[name="endereco-street-address"]').val(),
					entry_street_number             : CadastroCompleto.fomulario.find('input[name="endereco-street-number"]').val(),
					entry_suburb                    : CadastroCompleto.fomulario.find('input[name="endereco-suburb"]').val(),
					entry_city                      : CadastroCompleto.fomulario.find('input[name="endereco-city"]').val(),
					entry_state                     : CadastroCompleto.fomulario.find('input[name="endereco-state"]').val(),
					entry_rg                        : CadastroCompleto.fomulario.find('input[name="endereco-rg"]').val(),
					customers_cpf                   : CadastroCompleto.fomulario.find('input[name="cliente-cpf"]').val(),
					customers_gender                : CadastroCompleto.fomulario.find('input[name="cliente-gender"]').val(),
					customers_company               : CadastroCompleto.fomulario.find('input[name="razao-social"]').val(),
					customers_cnpj                  : CadastroCompleto.fomulario.find('input[name="cliente-cnpj"]').val(),
					customers_loja                  : CadastroCompleto.fomulario.find('input[name="cliente-loja"]').val(),
					qtd_funcionarios                : CadastroCompleto.fomulario.find('input[name="empresa-qtd-funcionarios"]').val(),
					profissao                       : CadastroCompleto.fomulario.find('input[name="cliente-profissao"]').val(),
					atividade                       : CadastroCompleto.fomulario.find('input[name="atividade-atividade"]').val(),
					cargo                           : CadastroCompleto.fomulario.find('input[name="empresa-cargo"]').val(),
					email_newsletter                : (CadastroCompleto.fomulario.find('input[name="cliente-newsletter"]').val() === 1 ? CadastroCompleto.fomulario.find('input[name="cliente-email"]').val() : ''),
					customers_conheceu              : CadastroCompleto.fomulario.find('input[name="cliente-como-conheceu"]').val(),
					customers_obs                   : CadastroCompleto.fomulario.find('input[name="cliente-obs"]').val(),
				}
			}).done(function (response) {
				if(response){
					alert('Cadastro efetuado com sucesso!');
					CadastroCompleto.fomulario[0].reset();
				}
				else{
					alert('Houve um erro ao efetuar o cadastro!')
				}
				CadastroCompleto.loadingHide();
			});
		},
		verificarCadastro: function () {

			CadastroCompleto.fomulario.validate(
				{
					debug: true,
					errorElement: 'div',
					errorClass: 'input-error',
					validClass: 'input-success',
					invalidHandler: function(f, v){
						if (!v.numberOfInvalids()){
							return;
						}
						$('html, body').animate(
							{
								scrollTop: $(v.errorList[0].element).offset().top - 150
							}, 	1000
						);
					},
					errorPlacement: function(error, element) {
						error.appendTo(element.closest(".form-group"));
					},
					submitHandler: function(form) {
						if ($(form).valid()){
							//form.submit();
							CadastroCompleto.salvarCadastro();
							return false; // prevent normal form posting
						}
					}
				}
			);

			CadastroCompleto.verificarCadastroRules();
			CadastroCompleto.verificarCadastroMethodsMasks();

		},
		verificarCadastroRules: function () {
			/*
			 * Nome
			 */
			$( '#field-cliente-nome' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Digite o seu nome.'
				}
			});
			/*
			 * Data de Nascimento
			 */
			$( '#field-cliente-dob' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Selecione a data do seu nascimento.'
				}
			});
			/*
			 * Email
			 */
			$( '#field-cliente-email' ).rules( 'add', {
				required: true,
				email: true,
				messages: {
					required: 'Digite o seu email.',
					email: 'O email digitado é inválido.'
				}
			});
			/*
			 * Senha
			 */
			$( '#field-cliente-password' ).rules( 'add', {
				required: true,
				minlength: 6,
				messages: {
					required: 'Digite uma senha.',
					minlength: 'A sua senha deve ter ao menos {0} caracteres.'
				},
			});
			/*
			 * ReSenha
			 */
			$( '#field-cliente-password-confirmation' ).rules( 'add', {
				required: true,
				equalTo: "#field-cliente-password",
				messages: {
					required: 'Redigite a sua senha.',
					equalTo: 'As senhas digitadas não são iguais.'
				}
			});
			/*
			 * Termo de Uso
			 */
			$( '#field-cliente-agree' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Você deve concordar com os termos de uso!',
				}
			});
			/*
			 * Celular
			 */
			$( '#field-cliente-celular').rules( 'add', {
				required: true,
				mobileBR: true, //calback regex in line 65
				messages: {
					required: 'Digite o número do seu celular.',
					mobileBR: 'Número de celular inválido.'
				}
			});
			/*
			 * Telefone
			 */
			$( '.tel-mask').rules( 'add', {
				required: true,
				mobileBR: true, //calback regex in line 65
				messages: {
					required: 'Digite o número do seu telefone.',
					mobileBR: 'Número de telefone inválido.'
				}
			});
			/*
			 * Aparelho
			 */
			$( '#field-comunicacao-aparelho').rules( 'add', {
				required: true,
				messages: {
					required: 'Digite o modelo do seu aparelho de celular.',
				}
			});
			/*
			 * Operadora
			 */
			$( '#field-comunicacao-operadora').rules( 'add', {
				required: true,
				messages: {
					required: 'Digite o operadora de telefonia do seu celular.',
				}
			});
			/*
			 * Skype
			 */
			$( '#field-comunicacao-skype').rules( 'add', {
				required: true,
				messages: {
					required: 'Digite o endereço do seu Skype.',
				}
			});
			/*
			 * Facebook
			 */
			$( '#field-comunicacao-facebook').rules( 'add', {
				required: true,
				messages: {
					required: 'Digite o endereço do seu Facebook.',
				}
			});
			/*
			 * Twitter
			 */
			$( '#field-comunicacao-twitter').rules( 'add', {
				required: true,
				messages: {
					required: 'Digite o endereço do seu Twitter.',
				}
			});
			/*
			 * CEP
			 */
			$( '.cep-mask').rules( 'add', {
				required: true,
				cepBR: true, //calback regex in line 65
				messages: {
					required: 'Digite o número do seu CEP.',
					cepBR: 'Número de CEP inválido.'
				}
			});
			/*
			 * Logradouro
			 */
			$( '#field-endereco-street-address' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Digite o logradouro.',
				}
			});
			/*
			 * Número Logradouro
			 */
			$( '#field-endereco-street-number' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Selecione o número do logradouro.',
				}
			});
			/*
			 * Bairro
			 */
			$( '#field-endereco-suburb' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Digite o bairro.',
				}
			});
			/*
			 * Cidade
			 */
			$( '#field-endereco-city' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Digite a cidade.',
				}
			});
			/*
			 * Estado
			 */
			$( '#field-endereco-state' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Selecione o seu estado.',
				}
			});
			/*
			 * RG
			 */
			$( '#field-endereco-rg' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Digite o número do seu RG.',
				}
			});
			/*
			 * CPF
			 */
			$( '#field-cliente-cpf' ).rules( 'add', {
				required: true,
				cpfBR: true,
				messages: {
					required: 'Digite o número do seu CPF.',
					cpfBR: 'Número de CPF inválido.'
				}
			});
			/*
			 * Sexo
			 */
			$( 'input[name="cliente-gender"]' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Escolha o sexo.'
				}
			});
			/*
			 * Empresa
			 */
			$( '#field-cliente-company' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Digite o nome da empresa.',
				}
			});
			/*
			 * CNPJ
			 */
			$( '.cnpj-mask' ).rules( 'add', {
				required: true,
				cnpjBR: true,
				messages: {
					required: 'Digite o CNPJ.',
					cnpjBR: 'Número de CNPJ inválido.'
				}
			});
			/*
			 * Loja
			 */
			$( '#field-cliente-loja' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Digite a loja.'
				}
			});

			/*
			 * Quantidade de Funcionarios
			 */
			$( '#field-empresa-qtd-funcionarios' ).rules( 'add', {
				required: true,
				digits: true,
				range: [1, Infinity],
				messages: {
					required: 'Selecione a quantidade de funcionarios.',
					digits: 'Quantidade de funcionarios inválida.',
					range: 'Escolha o valor de no mínimo 1 funcionário.'
				}
			});
			/*
			 * Profissão
			 */
			$( '#field-cliente-profissao' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Digite a sua profissão.'
				}
			});
			/*
			 * Atividade
			 */
			$( '#field-atividade-atividade' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Digite a sua atividade.'
				}
			});
			/*
			 * Cargo
			 */
			$( '#field-empresa-cargo' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Digite o seu cargo.'
				}
			});
			/*
			 * Sexo
			 */
			$( 'input[name="cliente-newsletter"]' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Deseja assina a nossa newsletter?'
				}
			});
			/*
			 * Como Conheçeu
			 */
			$( '#field-cliente-como-conheceu' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Digite como nos conheçeu.',
				}
			});
			/*
			 * Obervações
			 */
			$( '#field-cliente-obs' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Digite uma observação.',
				}
			});
		},
		verificarCadastroMethodsMasks: function () {
			/**
			 * Create Method in validator to accept mobile
			 * numbers BR with 9 or 8 numbers by Regex
			 */
			$.validator.addMethod('mobileBR', function (mobileBR, element) {
				mobileBR = mobileBR.replace(/[^\d]+/g,'');
				return this.optional(element) || mobileBR.length >= 10 && mobileBR.match( /^([0-9]{2})([9]{1})?([0-9]{4,5})([0-9]{4})$/ );
			});
			/**
			 * Create Method in validator to accept CNPJ
			 */
			$.validator.addMethod('cnpjBR', function (cnpjBR, element) {
				cnpjBR = cnpjBR.replace(/[^\d]+/g,'');
				return this.optional(element) || validCNPJ(cnpjBR);
			});
			function validCNPJ(cnpj) {

				cnpj = cnpj.replace(/[^\d]+/g,'');

				// Elimina CNPJs invalidos conhecidos
				var cnpj_obvious = [
					"00000000000000", "11111111111111", "22222222222222", "33333333333333", "44444444444444",
					"55555555555555", "66666666666666", "77777777777777", "88888888888888", "99999999999999"
				];

				if($.inArray(cnpj, cnpj_obvious) >= 0 || cnpj.length != 14 || cnpj == ''){
					return false;
				}

				// Valida DVs
				var cnpj_size 	= cnpj.length - 2
				var nums 		= cnpj.substring(0,cnpj_size);
				var digit 		= cnpj.substring(cnpj_size);
				var sum 		= 0;
				var pos 		= cnpj_size - 7;
				var intnx 		= cnpj_size;

				for (intnx; intnx >= 1; intnx--) {
					sum += nums.charAt(cnpj_size - intnx) * pos--;
					if (pos < 2){
						pos = 9;
					}
				}

				var result = sum % 11 < 2 ? 0 : 11 - sum % 11;

				if (result != digit.charAt(0)){
					return false;
				}

				cnpj_size = cnpj_size + 1;
				nums = cnpj.substring(0,cnpj_size);
				sum = 0;
				pos = cnpj_size - 7;
				intnx = cnpj_size

				for (intnx; intnx >= 1; intnx--) {
					sum += nums.charAt(cnpj_size - intnx) * pos--;
					if (pos < 2){
						pos = 9;
					}
				}

				result = sum % 11 < 2 ? 0 : 11 - sum % 11;
				if (result != digit.charAt(1)){
					return false;
				}
				return true;
			}

			/**
			 * Create Method in validator to accept CEP
			 * And fill in the fields related to the content
			 */
			$.validator.addMethod('cepBR', function (cepBR, element) {
				cepBR = cepBR.replace(/[^\d]+/g,'');
				return this.optional(element) || validCEP(cepBR);
			});
			function validCEP(cep) {
				/**
				 * Clean the adrees group form
				 */
				function prepareForm(txt) {
					$('#field-endereco-street-address').val(txt);
					$('#field-endereco-suburb').val(txt);
					$('#field-endereco-city').val(txt);
					$('#field-endereco-state').val(txt);
				};

				var cep_is_valid = true;
				//clean value
				if(cep.length != 8 || cep == ''){
					prepareForm('');
					return false;
				}
				//Test with Regex
				if(cep.match( /^[0-9]{8}$/)) {
					//Fill in the fields with '...' while get the webservice
					prepareForm('...');
					//Get the webservice
					$.ajax({
						type: "POST",
						contentType: "application/json",
						dataType: "json",
						async: false,
						data: JSON.stringify({
							'cep': cep
						}),
						url: amplizApiBase + '/cliente/auto-completar-endereco',
						beforeSend: function(xhr){
							if (amplizAuthorizationToken) {
								xhr.setRequestHeader('Authorization', amplizAuthorizationToken);
							}
						},
						success: function (d) {
							if (('erro' in d)) {
								prepareForm('');
								cep_is_valid = false; //When CEP not found or any error
							}else{
								//Updade fields with webservice data when not error and set valid to validator
								if(d.logradouro.length >= 1){
									$('#field-endereco-street-address').val(d.logradouro).valid();
								}
								if(d.bairro.length >= 1){
									$('#field-endereco-suburb').val(d.bairro).valid();
								}
								if(d.localidade.length >= 1){
									$('#field-endereco-city').val(d.localidade).valid();
								}
								if(d.uf.length >= 1){
									$('#field-endereco-state').val(d.uf).change().valid();
								}
								$('.cep-mask').removeClass('input-error').addClass('input-success');
								$('#field-endereco-postcode-error').hide(0);
								cep_is_valid = true;
							}
						}
					});
				}
				else {
					prepareForm('');
					return false;
				}
				return cep_is_valid;
			}
			/**
			 *	Prepere to recive Cell with 8 or 9 numbers
			 */
			var cellMaskBehavior = function (val) {
					return val.replace(/[^\d]+/g,'').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
				},
				cellOptions = {
					onKeyPress: function(val, e, field, options) {
						field.mask(cellMaskBehavior.apply({}, arguments), options);
					}
				};

			/**
			 *	Prepere to recive RG with 8 or 9 numbers
			 */
			var rgMaskBehavior = function (val) {
					return val.replace(/[^\d]+/g,'').length === 9 ? '00.000.000-0' : '00.000.0009';
				},
				rgOptions = {
					onKeyPress: function(val, e, field, options) {
						field.mask(rgMaskBehavior.apply({}, arguments), options);
					}
				};
			/**
			 * Set Email mask
			 */
			$('.email-mask').mask('A',
				{
					translation: {
						'A': {
							pattern: /^[a-z0-9\@-_.-/s]$/,
							recursive: true
						}
					}
				}
			);
			/**
			 * Show/Hide password toogle
			 */
			$('.showpassword').hidePassword(true,
				{
					states: {
						shown: {
							toggle: {
								content: 'Esconder',
							}
						},
						hidden: {
							toggle: {
								content: 'Mostrar',
							}
						}
					}
				}
			);
			/**
			 * Set Cell mask
			 */
			$('.cel-mask').mask(cellMaskBehavior,
				{
					cellOptions,
					placeholder: '(__) ____-____'
				}
			);

			/**
			 * Set CPF mask
			 */
			$('.cpf-mask').mask('000.000.000-00',
				{
					placeholder: '___.___.___-__'
				}
			);

			/**
			 * Set RG mask
			 */
			$('.rg-mask').mask(rgMaskBehavior,
				{
					rgOptions,
					placeholder: '__.___.___-_'
				}
			);
			/**
			 * Set CNPJ mask
			 */
			$('.cnpj-mask').mask('00.000.000/0000-00',
				{
					placeholder: '__.___.___/____-__'
				}
			);

			/**
			 * Set Telefone mask
			 */
			$('.tel-mask').mask(cellMaskBehavior,
				{
					cellOptions,
					placeholder: '(__) ____-____'
				}
			);

			$('.cep-mask').mask('00000-000',
				{
					placeholder: '_____-___'
				}
			);
			/**
			 * Set Logradouro Numero
			 */
			$('.int-mask').mask('A',
				{
					translation: {
						'A': {
							pattern: /\d/,
							recursive: true
						}
					}
				}
			);

		},
		loadingShow: function () {
			CadastroCompleto.cadastro.append('<div class="mp-loading-inner"></div>');
			CadastroCompleto.cadastro.addClass('mp-loading');
		},
		loadingHide: function () {
			$(' > .mp-loading-inner', CadastroCompleto.cadastro).remove();
			CadastroCompleto.cadastro.removeClass('mp-loading');
		},
	};
	CadastroCompleto.init();
})(jQuery);
