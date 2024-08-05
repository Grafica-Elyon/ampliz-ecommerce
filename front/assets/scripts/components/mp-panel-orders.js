import Components from "../Components";
import Accordion from "../Accordion";

export default function (el) {
	new Accordion(el);

	function paginate(page, table)
	{
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'mp_orders',
				'data': {
					page: page,
					params: $(' [name="params"]', el).val(),
				},
			}
		}).done((response) => {
			$('.mp-accordions', el).html(response);
			Components.loading(el, 'stop');
			(new Components).loadAll(); // registry new sub components
		});
	}

	$(' .mp-load-more', el).click((event) => {
		Components.loading(el);
		let load_more = $(event.currentTarget);
		let table = $(' #table-orders', el);
		let page = table.data('page');
		page = page+1;
		table.data('page', page);

		if(page == table.data('lastpage')) {
			load_more.fadeOut();
		}

		changePage(page);
		event.preventDefault();
	});

	$(el).on('click', '#orders-pagination .mp-pagination-list a', function (event) {
		let target = $(event.target);
		let page = target.data('page');
		let accordion = $(el).find('.mp-accordion');

		if ( !page ) {
			return;
		}

		Components.loading(el);

		$('#orders-pagination .mp-pagination-list li').removeClass('active');
		target.parent().addClass('active');

		goToTop();
		changePage(page);
		paginationButtonsUpdate();
	});

	function goToTop() {
		$('html, body').animate({ scrollTop: $('.mp-accordions', el).offset().top - 120 }, 800);
	}

	function paginationButtonsUpdate() {
		let list = $('#orders-pagination .mp-pagination-list li:not(.helper)');
		let active = $('#orders-pagination .mp-pagination-list li.active');
		let index = list.index( active );
		let length = list.length;
		let viewButtons = 3;

		list.show();
		$('#orders-pagination .mp-pagination-list li.helper').hide();

		if ( index > viewButtons ) {
			list.slice( 0, index-viewButtons ).hide();

			list.first().show();
			if ( index > viewButtons + 1 ) {
				$('#orders-pagination .mp-pagination-list li.helper.first-helper').show()
			}
		}

		if ( index <= length - viewButtons ) {
			list.slice( index + viewButtons + 1 ).hide();

			list.last().show();
			if ( index <= length - viewButtons - 1 ) {
				$('#orders-pagination .mp-pagination-list li.helper.last-helper').show()
			}
		}

		if ( index <= viewButtons ) {
			list.slice( 0, viewButtons*2 ).show();
		}
		if ( index > length - viewButtons ) {
			list.slice( length - viewButtons*2 ).show();
		}
	}

	paginationButtonsUpdate();

	$(el).find('.mp-accordion-orders').each(function () {
		let accordion = $(this)
		let showRows = 5
		let addRows = 5
		let rows = accordion.find('.mp-table-order-history tbody tr:not(:last-child)')
		let showMoreRows = accordion.find('.mp-table-order-history tbody tr:last-child')

		let updateRows = function() {
			rows.slice( 0, showRows ).show()
			rows.slice( showRows ).hide()
			showRows < rows.length ? showMoreRows.show() : showMoreRows.hide()
		}
		updateRows()

		showMoreRows.click(function () {
			showRows+=addRows
			updateRows()
		})
	})

	$(el).find('#filtro-orders').on('change', function(){
		Components.loading(el, 'start');
		let filtro = $(this).val();
		changeFilter();
	
	});

	let filtro;
	let pagina;
	
	function changeFilter(){
		console.log("changeFilter")
		filtro = $('#filtro-orders').val();
		update();
	}

	function changePage(page){
		pagina = page;
		update();
	}

	function update(){
		console.log("update");
		$.ajax({
			method: "POST",
			url: wp.ajax_url,
			data: {
				action: 'mp_orders',
				'data': {
					page: pagina,
					params: $(' [name="params"]', el).val(),
					filter: filtro,
				},
			}
		}).done((response) => {
			$('.mp-accordions', el).html(response);
			Components.loading(el, 'stop');
			(new Components).loadAll(); // registry new sub components
		});
	}
}
