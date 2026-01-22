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
	window.CadastroIncompleto = {
		cadastro            : $('.cadastro'),
		fomulario           : $('#cadastro-incompleto'),
		init: function () {
			CadastroIncompleto.verificarCadastro();
		},
		salvarCadastro: function () {
			var form = $('#cadastro-incompleto');
			CadastroIncompleto.loadingShow();
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action          : 'cadastro_incompleto',
					expects         : 'add',
					nome            : form.find('input[name="nome"]').val(),
					email           : form.find('input[name="email"]').val(),
					telefone        : form.find('input[name="telefone"]').val(),
					profissao       : form.find('input[name="profissao"]').val(),
					cep             : form.find('input[name="cep"]').val(),
					comoConheceu    : form.find('input[name="comoConheceu"]').val(),
				}
			}).done(function (response) {
				if(response){
					alert('Cadastro efetuado com sucesso!');
					CadastroIncompleto.fomulario[0].reset();
				}
				else{
					alert('Houve um erro ao efetuar o cadastro!')
				}
				CadastroIncompleto.loadingHide();
			});
		},
		verificarCadastro: function () {
			CadastroIncompleto.fomulario.validate(
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
							CadastroIncompleto.salvarCadastro();
							return false; // prevent normal form posting
						}
					}
				}
			);
			CadastroIncompleto.verificarCadastroRules();
			CadastroIncompleto.verificarCadastroMasksMethods();
		},
		verificarCadastroRules:function () {
			/*
			 * Nome
			 */
			$( '#field-nome' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Digite o seu nome.'
				}
			});
			/*
			 * Email
			 */
			$( '#field-email' ).rules( 'add', {
				required: true,
				email: true,
				messages: {
					required: 'Digite o seu email.',
					email: 'O email digitado é inválido.'
				}
			});
			/*
			 * Telefone
			 */
			$( '.tel-mask').rules( 'add', {
				required: true,
				mobileBR: true, //calback regex in line 65
				messages: {
					required: 'Digite o número do seu telefone, fixo ou celular.',
					mobileBR: 'Número de telefone inválido.'
				}
			});
			/*
			 * Profissão
			 */
			$( '#field-profissao' ).rules( 'add', {
				required: true,
				messages: {
					required: 'Digite a sua profissão.'
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
			 * Telefone
			 */
			$( '#field-conheceu').rules( 'add', {
				required: true,
				messages: {
					required: 'Digite como conheceu a nossa empresa.'
				}
			});
		},
		verificarCadastroMasksMethods:function () {
			/*
			 * Telefone
			 */
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
			 * Create Method in validator to accept mobile
			 * numbers BR with 9 or 8 numbers by Regex
			 */
			$.validator.addMethod('mobileBR', function (mobileBR, element) {
				mobileBR = mobileBR.replace(/[^\d]+/g,'');
				return this.optional(element) || mobileBR.length >= 10 && mobileBR.match( /^([0-9]{2})([9]{1})?([0-9]{4,5})([0-9]{4})$/ );
			});
			/**
			 * Set Telefone mask
			 */
			$('.tel-mask').mask(cellMaskBehavior,
				{
					cellOptions,
					placeholder: '(__) ____-____'
				}
			);
			/*
			 * CEP
			 */

			/**
			 * Create Method in validator to accept CEP
			 * And fill in the fields related to the content
			 */
			$.validator.addMethod('cepBR', function (cepBR, element) {
				cepBR = cepBR.replace(/[^\d]+/g,'');
				return this.optional(element) || validCEP(cepBR);
			});
			function validCEP(cep) {

				var cep_is_valid = true;
				//clean value
				if(cep.length != 8 || cep == ''){
					cep_is_valid = false;
				}
				//Test with Regex
				if(cep.match( /^[0-9]{8}$/)) {
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
								cep_is_valid = false; //When CEP not found or any error
							}
						}
					});
				}
				else {
					cep_is_valid = false;
				}
				return cep_is_valid;
			};
			$('.cep-mask').mask('00000-000',
				{
					placeholder: '_____-___'
				}
			);
		},
		loadingShow: function () {
				CadastroIncompleto.cadastro.append('<div class="mp-loading-inner"></div>');
				CadastroIncompleto.cadastro.addClass('mp-loading');
		},
		loadingHide: function () {
			$(' > .mp-loading-inner', CadastroIncompleto.cadastro).remove();
			CadastroIncompleto.cadastro.removeClass('mp-loading');
		},
	};
	CadastroIncompleto.init();
})(jQuery);
