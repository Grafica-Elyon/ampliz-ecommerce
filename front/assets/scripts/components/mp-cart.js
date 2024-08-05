import Components from '../Components';
export default function (el) {
	var registerEvent = () => {
		$(' [data-cart]', el).click((event) => {
			event.preventDefault();

			Components.loading(el);
			var element = $(event.currentTarget);

			sendAction(element);
		});
	}

	var sendAction = (element) => {
		var id=element.data('cart');
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'mp_cart',
				data: {
					action: element.data('action'),
					id: element.data('cart'),
					qtd: $('#qtd-'+id).val(),
					art: element.data('art'),
				}
			}
		}).done((response) => {
			$(' .mp-config-print-prices', el).html(response);
			registerEvent();
			if(element.data('action') === 'delete' || element.data('action') === 'copy') {
				location.reload();
			} else {
				Components.loading(el, 'stop');
			}
		});
	}

	registerEvent();
}
