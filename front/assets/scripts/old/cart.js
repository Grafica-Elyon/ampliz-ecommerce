(function ($) {
	window.Cart = {
		cart                : $('.mp-cart'),
		cart_totals         : $('.mp-cart-totals'),
		cart_view           : $('.cart-view').parent().html(),
		cart_totals_view    : $('.cart-totals-view').parent().html(),
		products            : [],
		init: function () {
			$('.cart-view').remove();
			$('.cart-totals-view').remove();
			Cart.getProducts();
		},
		getProducts: function () {
			return Cart.ajaxRequest();
		},
		ajaxRequest: function () {
			Cart.loadingShow();
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {action: 'cart'}
			}).done(function (response) {
				Cart.loadView(response.cart, Cart.cart_view, Cart.cart);
				Cart.loadView(response.cart_totals, Cart.cart_totals_view, Cart.cart_totals);
			});
		},
		loadingShow: function () {
			var contents = Cart.getLoadingContents();
			for (var i = 0; i < contents.length; i++) {
				contents[i].append('<div class="mp-loading-inner"></div>');
				contents[i].addClass('mp-loading');
			}
		},
		loadingHide: function () {
			var contents = Cart.getLoadingContents();
			for (var i = 0; i < contents.length; i++) {
				$(' > .mp-loading-inner', contents[i]).remove();
				contents[i].removeClass('mp-loading');
			}
		},
		getLoadingContents: function () {
			return [Cart.cart,Cart.cart_totals];
		},
		loadView: function (data, view, container) {
			var html = '';
			Mustache.parse(view);
			for (var i = 0; i < data.length; i++) {
				html += Mustache.render(view, data[i]);
			}
			$(' > table > tbody', container).html(html);
			Cart.loadingHide();
		}
	};
	Cart.init();
})(jQuery);
