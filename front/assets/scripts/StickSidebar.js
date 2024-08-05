export default class StickSidebar {
	constructor(sidebar) {
		let w = $(window);
		let offset = sidebar.offset();
		let topPadding =  30;
		if(w.width() > 768) {
			w.scroll(function() {
				let heightLimit = document.body.offsetHeight - ($('#site-footer').height() + sidebar.height() + topPadding + 80);
				if (w.scrollTop() > offset.top) {
					if (w.scrollTop() < heightLimit) {
						sidebar.stop().animate({
							marginTop: w.scrollTop() - offset.top + topPadding
						}, 0);
					}
				} else {
					sidebar.stop().animate({
						marginTop: 0
					});
				}
			});
		}
	}
}
