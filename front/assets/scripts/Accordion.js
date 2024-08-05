export default class Accordion {
	constructor(el) {
		this.accordion(el);
	}

	accordion(el) {
		$(el).find('.mp-accordion.active .mp-accordion-body, .mp-accordion-orders.active .mp-accordion-body').slideDown();

		$(el).on('click', '.mp-accordion-header', event => {
			const accordion = $(event.currentTarget);

			if (accordion.parent().hasClass('active')) {
				$('.mp-accordion, .mp-accordion-orders').removeClass('active');
				$('.mp-accordion-body').slideUp();
			} else {
				$('.mp-accordion, .mp-accordion-orders').removeClass('active');
				$('.mp-accordion-body').slideUp();
				accordion.parents('.mp-accordion, .mp-accordion-orders').addClass('active');
				accordion.parents('.mp-accordion, .mp-accordion-orders').find('.mp-accordion-body').slideDown();
			}
		});
	}
}
