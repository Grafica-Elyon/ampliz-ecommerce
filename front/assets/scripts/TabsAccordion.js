export default class TabsAccordion {
	constructor(el) {
		this.accordion(el);
		this.tabs(el);
	}

	accordion(el) {
		$(el).on('click', '.mp-tab-header', event => {
			if ($(event.currentTarget).parent().hasClass('active')) {
				$('.mp-tab-content').removeClass('active');
			} else {
				$('.mp-tab-content').removeClass('active');
				const content = $(event.currentTarget).parents('.mp-tab-content');
				content.addClass('active');
				$('.mp-nav li').removeClass('active');
				$('.mp-nav li[data-tab="' + content.attr('id') + '"]').addClass('active');
			}
		});
	}

	tabs(el) {
		$(el).on('click', '.mp-nav li', event => {
			const tab = $(event.currentTarget);
			if (!tab.hasClass('active')) {
				$('.mp-nav li, .mp-tab-content').removeClass('active');
				tab.addClass('active');
				$('#' + tab.data('tab')).addClass('active');
			}
		});
	}
}
