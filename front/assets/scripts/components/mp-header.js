export default function () {
	$('.mp-dropdown-toggle').on('click', event => {
		$(event.currentTarget).parent().find('.mp-dropdown-menu').toggle();
		$(event.currentTarget).toggleClass('mp-open');
	});

	$('.mp-dropdown-menu-mega .mp-dropdown-link').on('click', event => {
		event.preventDefault();
		const id = $(event.currentTarget).attr('href');

		$('.mp-dropdown-link').removeClass('mp-active');
		$('.mp-dropdown-menu-mega-content').removeClass('mp-active');

		$(id).addClass('mp-active');
		$(event.currentTarget).addClass('mp-active');
	});
}
