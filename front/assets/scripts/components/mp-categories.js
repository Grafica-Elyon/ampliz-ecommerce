import Components from '../Components';
export default function (el) {
	var registerEvent = () => {
		$(' .mp-pagination a', el).click((event) => {
			event.preventDefault();
			var element = $(event.currentTarget);
			var parent = element.parent('li');
			if(!(parent.is('.active'))) {
				Components.loading(el);
				sendAction(element);
			}
		});
	}

	var sendAction = (element) => {
		var page = element.data('page');
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'mp_categories',
				params: $(' [name="params"]', el).val(),
				page: page
			}
		}).done((response) => {
			$(el).html(response);
			Components.loading(el, 'stop');
			registerEvent();
		});
	}

	registerEvent();
}
