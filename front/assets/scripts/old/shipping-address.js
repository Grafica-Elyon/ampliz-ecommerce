(function ($) {
	window.ShippingAddress = {
		shipping_address        : $('.mp-shipping-address'),
		shipping_address_view   : $('.shipping-address-view').parent().html(),
		addresses               : [],
		init: function () {
			$('.shipping-address-view').remove();
			ShippingAddress.getAddress();
			/**
			 * Close Light Box e Hide all content divs
			 */
			$('.mp-lightbox > .overlay, ' +
				'.mp-lightbox > .content a.boxclose, ' +
				'.mp-btn-del-no, ' +
				'.mp-btn-sucess-ok, ' +
				'.mp-btn-error-ok'
			)
				.on('click', function () {
				ShippingAddress.closeLightBox();
			})

			$('body').on('change', ':checkbox', ShippingAddress.shipping_address, function(){
				$(':checkbox', ShippingAddress.shipping_address).prop('checked', false);
				$(this).prop('checked', true);
			});
			/**
			 * ADD ADDRESS
			 */
			$('body').on('click', '.mp-btn-add-address', ShippingAddress.shipping_address, function() {
				ShippingAddress.addAddress();
			});
			$('body').on('click', '.mp-btn-save-add-address', ShippingAddress.shipping_address, function() {
				ShippingAddress.saveNewAddress();
			});
			/**
			 * EDIT ADDRESS
			 */
			$('body').on('click', '.mp-btn-edit-address', ShippingAddress.shipping_address, function() {
				ShippingAddress.editAddress($(this));
			});
			$('body').on('click', '.mp-btn-save-edit-address', ShippingAddress.shipping_address, function() {
				ShippingAddress.saveEditAddress($(this));
			});
			/**
			 * DEL ADDRESS
			 */
			$('body').on('click', '.mp-btn-del-address', ShippingAddress.shipping_address, function() {
				ShippingAddress.delAddress($(this));
			});
			$('body').on('click', '.mp-btn-del-yes', ShippingAddress.shipping_address, function() {
				ShippingAddress.delConfirmAddress($(this));
			});

		},
		addAddress: function () {
			var form = ShippingAddress.getAddressForm();
			ShippingAddress.openAddressForm();
			form.find('h1').text(form.find('input[name="shipping_address_title_add"]').val());
			form.find('.mp-btn').addClass('mp-btn-save-add-address');
		},
		saveNewAddress: function () {
			var form = ShippingAddress.getAddressForm();
			ShippingAddress.loadingShow();
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: 'shipping_address',
					expects: 'add',
					rua: form.find('input[name="rua"]').val(),
					numero: form.find('input[name="numero"]').val(),
					cep: form.find('input[name="cep"]').val(),
					bairro: form.find('input[name="bairro"]').val(),
					cidade: form.find('input[name="cidade"]').val(),
					estado: form.find('input[name="estado"]').val(),
					pais: form.find('input[name="pais"]').val(),
					telefone: form.find('input[name="telefone"]').val(),

				}
			}).done(function (response) {
				form.find('.mp-btn').removeClass('mp-btn-save-add-address');
				form.find('h1').text('');
				ShippingAddress.closeLightBox();
				setTimeout(function() {
					ShippingAddress.openSuccessErrorDialog(
						response,
						'shipping_address_title_add_sucess',
						'shipping_address_title_add_err'
					);
				}, 1000);
				ShippingAddress.getAddress();
			});
		},
		editAddress: function(act){

			ShippingAddress.openAddressForm();

			var form = ShippingAddress.getAddressForm();
			var tr = act.closest('tr');
			form.find('h1').text(form.find('input[name="shipping_address_title_edit"]').val());

			form.find('input[name="codigoEnd"]').val(act.data('id'));
			form.find('input[name="rua"]').val(tr.find('.rua').text());
			form.find('input[name="numero"]').val(tr.find('.numero').text());
			form.find('input[name="cep"]').val(tr.find('.cep').text());
			form.find('input[name="bairro"]').val(tr.find('.bairro').text());
			form.find('input[name="cidade"]').val(tr.find('.cidade').text());
			form.find('input[name="estado"]').val(tr.find('.estado').text());
			form.find('input[name="pais"]').val(tr.find('.pais').text());
			form.find('input[name="telefone"]').val(tr.find('.telefone').text());

			form.find('.mp-btn').addClass('mp-btn-save-edit-address');

		},
		saveEditAddress: function () {
			var form = ShippingAddress.getAddressForm();
			ShippingAddress.loadingShow();
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: 'shipping_address',
					expects: 'edit',
					codigoEnd: form.find('input[name="codigoEnd"]').val(),
					rua: form.find('input[name="rua"]').val(),
					numero: form.find('input[name="numero"]').val(),
					cep: form.find('input[name="cep"]').val(),
					bairro: form.find('input[name="bairro"]').val(),
					cidade: form.find('input[name="cidade"]').val(),
					estado: form.find('input[name="estado"]').val(),
					pais: form.find('input[name="pais"]').val(),
					telefone: form.find('input[name="telefone"]').val(),
				}
			}).done(function (response) {
				ShippingAddress.getAddressForm().find('.mp-btn').removeClass('mp-btn-save-edit-address');
				ShippingAddress.closeLightBox();
				setTimeout(function() {
					ShippingAddress.openSuccessErrorDialog(
						response,
						'shipping_address_title_edit_sucess',
						'shipping_address_title_edit_err'
					);
				}, 1000);
				ShippingAddress.getAddress();
			});

		},
		delAddress: function (act) {
			var form = ShippingAddress.getAddressForm();
			form.find('h1').text(form.find('input[name="shipping_address_title_del"]').val());
			form.find('input[name="codigoEnd"]').val(act.data('id'));
			ShippingAddress.openConfirmBox();
		},
		delConfirmAddress: function () {
			var form = ShippingAddress.getAddressForm();
			ShippingAddress.loadingShow();
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: 'shipping_address',
					expects: 'del',
					codigoEnd: form.find('input[name="codigoEnd"]').val(),
				}
			}).done(function (response) {
				form.find('h1').text('');
				ShippingAddress.closeLightBox();
				setTimeout(function() {
					ShippingAddress.openSuccessErrorDialog(
						response,
						'shipping_address_title_del_sucess',
						'shipping_address_title_del_err'
					);
				}, 1000);
				ShippingAddress.getAddress();
			});
		},
		getAddress: function () {
			$('.shipping-address-view').remove();
			ShippingAddress.loadingShow();
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: 'shipping_address',
					expects: 'get'
				}
			}).done(function (response) {
				ShippingAddress.loadAddresses(response);
			});
		},
		loadAddresses: function (addresses) {
			var html = '';
			Mustache.parse(ShippingAddress.shipping_address_view);
			for (var i = 0; i < addresses.length; i++) {
				html += Mustache.render(ShippingAddress.shipping_address_view, addresses[i]);
			}
			$(' > table > tbody', ShippingAddress.shipping_address).html(html);
			ShippingAddress.loadingHide();
		},
		loadingShow: function () {
			ShippingAddress.shipping_address.append('<div class="mp-loading-inner"></div>');
			ShippingAddress.shipping_address.addClass('mp-loading');
		},
		loadingHide: function () {
			$(' > .mp-loading-inner', ShippingAddress.shipping_address).remove();
			ShippingAddress.shipping_address.removeClass('mp-loading');
		},
		getAddressForm: function () {
			return $('.mp-forms');
		},
		closeLightBox: function () {
			$('.mp-lightbox').fadeOut(200, function () {
				$('.mp-add-edit-form, .mp-del-form, .mp-sucess-form, .mp-error-form').hide(0);
			});
		},
		openAddressForm: function () {
			$('.mp-del-form').hide(0);
			$('.mp-add-edit-form').show(0);
			$('.mp-forms').find('input:text').val('');
			$('.mp-lightbox').fadeIn(600);
		},
		openConfirmBox: function () {
			$('.mp-add-edit-form').hide(0);
			$('.mp-del-form').show(0);
			$('.mp-forms').find('input:text').val('');
			$('.mp-lightbox').fadeIn(600);
		},
		openSuccessErrorDialog: function (response, title_success, title_error) {
			var title = '';
			if(response){
				title = ShippingAddress.getAddressForm().find('input[name="' + title_success + '"]').val();
				$('.mp-sucess-form').show(0);
			}else{
				title = ShippingAddress.getAddressForm().find('input[name="' + title_error + '"]').val();
				$('.mp-error-form').show(0);
			}
			ShippingAddress.getAddressForm().find('h1').text(title);
			$('.mp-lightbox').fadeIn(600);
		}
	};
	ShippingAddress.init();
})(jQuery);