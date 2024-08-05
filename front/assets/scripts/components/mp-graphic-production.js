export default function (el) {

	$(el).find('.mp-default-carousel').owlCarousel({
		loop: false,
		items: 1,
		nav: true,
		navText: ['<i></i>','<i></i>'],
		dots: true
	})
}

