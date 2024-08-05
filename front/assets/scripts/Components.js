import Scripts from './Scripts';

export default class Components {
	constructor() {
		this.loadAll();
	}

	loadAll() {
		this.scripts = new Scripts();
		$('[data-component]').each((i, el) => {
			if ( Components.isLoaded( el ) ) {
				return;
			}
			let component = $(el).data('component');
			Components.loading(el);
			let ajax = $(el).data('ajax');
			let data = $(el).data();
			let params = $(el).parent().find('input[name="params"]').val();
			if(typeof ajax === 'undefined' || ajax == '1') {
				this.ajaxRequest(component, el, data, params);
			} else {
				this.scripts.load(el);
				Components.loading(el, 'stop');
			}
			Components.registryLoad( el );
		});
	}

	reload( el ) {
		Components.removeLoad(el);
		$(el).off();
		this.loadAll();
	}

	ajaxRequest(component, el, data, params) {
		data = data || [];
		params = params || [];
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'components',
				component: component,
				data: data,
				params: params
			}
		}).done((response) => {
			$(el).html(response);
			this.scripts.load(el);
			Components.loading(el, 'stop');
			this.loadAll();
		});
	}

	static isLoaded ( el ) {
		return !!$(el).data('data-component-loaded');
	}
	static registryLoad ( el ) {
		return $(el).data('data-component-loaded', true);
	}
	static removeLoad ( el ) {
		return $(el).data('data-component-loaded', false);
	}

	static loading(component, action) {
		action = action || 'start';

		if(action == 'stop') {
			$(component).attr('data-loading', 'off');
			return;
		}

		$(component).attr('data-loading', 'on');
		return;
	}
}
