(function ($) {
	window.Shipping = {
		shipping_container  : $('.mp-shipping'),
		shipping_method     : $('.mp-shipping .shipping-methods'),
		shipping_methods    : $('.mp-shipping .shipping-methods > [data-shipping]'),
		shipping_options    : $('.mp-shipping > .shipping-options'),
		shipping_view       : $('.shipping-view').parent().html(),
		options: [],
		/* INICIO */
		shipping: function () {
			$('.shipping-view').remove();
			Shipping.shipping_methods.click(function () {
				Shipping.loadingShow();
				Shipping.changeShippingMethod($(this));
				event.preventDefault();
			});
		},
		ajaxRequest: function (method) {
			$('.shipping-view').remove();
			Shipping.loadingShow();
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: 'shipping',
					expects: 'shipping_method',
					method: method,
				}
			}).done(function (response) {
				Shipping.saveResponse(response);
			});
		},
		saveResponse: function (response) {
			Shipping.options = response;
			Shipping.fillOptions();
		},
		fillOptions: function () {
			var html = '';
			Mustache.parse(Shipping.shipping_view);
			for (var i = 0; i < Shipping.options.length; i++) {
				html += Mustache.render(Shipping.shipping_view, Shipping.options[i]);
			}
			$(' > table > tbody', Shipping.shipping_options).html(html);
			Shipping.loadingHide();
		},
		changeShippingMethod: function (shipping) {
			let method = shipping.data('shipping');
			Shipping.ajaxRequest(method);
		},
		getLoadingContents: function () {
			return [Shipping.shipping_container];
		},
		loadingShow: function () {
			var contents = Shipping.getLoadingContents();
			for (var i = 0; i < contents.length; i++) {
				contents[i].append('<div class="mp-loading-inner"></div>');
				contents[i].addClass('mp-loading');
			}
		},
		loadingHide: function () {
			var contents = Shipping.getLoadingContents();
			for (var i = 0; i < contents.length; i++) {
				$(' > .mp-loading-inner', contents[i]).remove();
				contents[i].removeClass('mp-loading');
			}
		},
	};
	Shipping.shipping();
})(jQuery);
