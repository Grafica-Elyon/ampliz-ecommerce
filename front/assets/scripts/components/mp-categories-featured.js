import TabsAccorion from '../TabsAccordion';
import AsyncImages from '../AsyncImages';

export default function (el) {

	new TabsAccorion(el);
	new AsyncImages(el);
	owl_mobile();

	$(window).on('resize', () => {
		owl_mobile();
	});

	function owl_mobile() {
		const listing = $('.mp-listing');

		if ($(window).width() <= '600') {
			listing.addClass('owl-carousel owl-theme');
			$(el).find('.mp-listing').owlCarousel({
				loop: false,
				nav: true,
				dots: false,
				items: 1,
			});
			$('.mp-hide-carousel').parent().hide();
		} else {
			if (listing.hasClass('owl-carousel')) {
				listing.trigger('destroy.owl.carousel').removeClass('owl-carousel owl-theme');
				listing.find('.owl-stage-outer').children().unwrap();
				if (listing.hasClass('owl-hidden')) {
					listing.removeClass('owl-hidden');
				}
			}
		}
	}
}
