(function ($) {
	window.ClientAuthentication = {

		form : {
			container   : $( "#autenticacao" ),
			email       : $( "#autenticacao" ).find( "input[name='usuario']" ),
			senha       : $( "#autenticacao" ).find( "input[name='senha']" )
		},

		init : function () {
			$('body').on('click',  "#client-authentication-submit", ClientAuthentication.form.container, function(event){
				event.preventDefault();
				ClientAuthentication.login();
			});
		},

		login: function () {
			ClientAuthentication.loadingShow();
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action : 'user_login',
					email  : ClientAuthentication.form.email.val(),
					senha  : ClientAuthentication.form.senha.val()
				}
			}).done(function (response) {
				if(response){
					alert('Login efetuado com sucesso!');
					ClientAuthentication.redirect(wp.login_success_page);
				}
				else{
					alert('Usuário e ou senha inválidos!')
				}
				ClientAuthentication.loadingHide();
			});
		},

		redirect: function (url) {
			let ua        = navigator.userAgent.toLowerCase(),
				isIE      = ua.indexOf('msie') !== -1,
				version   = parseInt(ua.substr(4, 2), 10);
			if (isIE && version < 9) {
				var link = document.createElement('a');
				link.href = url;
				document.body.appendChild(link);
				link.click();
			}
			else {
				window.location.href = url;
			}
		},

		loadingShow: function () {
			ClientAuthentication.form.container.append('<div class="mp-loading-inner"></div>');
			ClientAuthentication.form.container.addClass('mp-loading');
		},

		loadingHide: function () {
			$(' > .mp-loading-inner', ClientAuthentication.form.container).remove();
			ClientAuthentication.form.container.removeClass('mp-loading');
		}
	}
	ClientAuthentication.init();
})(jQuery);