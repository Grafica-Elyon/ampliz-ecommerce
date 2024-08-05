(function ($) {
	window.ProductFilter = {
		product: {
			thumbnail       : $('.mp-product-thumbnail'),
			detail          : $('.mp-product-detail'),
			price_table     : $('.mp-product-price-table'),
			price_view      : $('.product-price-view').parent().html(),

		},
		filter: $('.mp-product-filter'),
		format: $('.mp-product-format'),
		print: $('.mp-product-print'),
		paper: $('.mp-product-paper'),
		ennoblement: $('.mp-product-ennoblement'),
		finishing: $('.mp-product-finishing'),
		extra: $('.mp-product-extra'),

		getCategory: function () {
			return ProductFilter.filter.data('category');
		},

		getFormat: function () {
			return ProductFilter.getFormatSelect().val();
		},

		getPrint: function () {
			return ProductFilter.getPrintSelect().val();
		},

		getPaper: function () {
			return ProductFilter.getPaperSelect().val();
		},

		getEnnoblement: function () {
			return ProductFilter.getEnnoblementSelect().val();
		},

		getFinishing: function () {
			return ProductFilter.getFinishingSelect().val();
		},

		getExtra: function () {
			return ProductFilter.getExtraSelect().val();
		},

		getFormatSelect: function () {
			return $(' > select', ProductFilter.format);
		},

		getPrintSelect: function () {
			return $(' > select', ProductFilter.print);
		},

		getPaperSelect: function () {
			return $(' > select', ProductFilter.paper);
		},

		getEnnoblementSelect: function () {
			return $(' > select', ProductFilter.ennoblement);
		},

		getFinishingSelect: function () {
			return $(' > select', ProductFilter.finishing);
		},

		getExtraSelect: function () {
			return $(' > select', ProductFilter.extra);
		},

		loadProduct: function (product) {
			$(' > h2', ProductFilter.product.detail).text(product.nome);
			$(' > .mp-description', ProductFilter.product.detail).text(product.descricao);
			$(' > .mp-initial-price .price', ProductFilter.product.detail).text(product.precoAPartirDe);

			if ('' !== product.urlImagem) {
				$(' > img', ProductFilter.product.thumbnail).attr('src', product.urlImagem);
			} else {
				$(' > img', ProductFilter.product.thumbnail).attr('src', 'http://via.placeholder.com/260x130/cdd3d8/0275d8/?text=SEM IMAGEM');
			}
		},

		fillSelect: function (select, data, key) {
			key = key || false;
			if(Object.keys(data).length > 0) {
				select.html('<option value="">' + select.data('placeholder') + '</option>');
				for (let i in data) {
					if (key) {
						select.append('<option value="' + i + '">' + data[i] + '</option>');
					} else {
						select.append('<option value="' + data[i] + '">' + data[i] + '</option>');
					}
				}
				select.prop('disabled', false);
				select.change();
			} else {
				select.html('<option value="">-</option>');
				select.prop('disabled', 'disabled');
			}
		},

		clearSelect: function (selects) {
			for (let i in selects) {
				selects[i].html('<option value="">-</option>');
				selects[i].prop('disabled', 'disabled');
			}
		},

		saveResponse: function (response) {
			for (let i in response) {
				if ('product' === i) {
					ProductFilter.loadProduct(response[i]);
				}

				if ('formats' === i) {
					ProductFilter.loadFormat(response[i]);
				}

				if ('prints' === i) {
					ProductFilter.loadPrint(response[i]);
				}

				if ('papers' === i) {
					ProductFilter.loadPaper(response[i]);
				}

				if ('ennoblements' === i) {
					ProductFilter.loadEnnoblement(response[i]);
				}

				if ('finishings' === i) {
					ProductFilter.loadFinishing(response[i]);
				}

				if ('extras' === i) {
					ProductFilter.loadExtra(response[i]);
				}

				if ('prices' === i) {
					ProductFilter.loadPrices(response[i]);
				}
			}
		},

		ajaxRequest: function (expects) {
			$('.product-price-view').remove();
			ProductFilter.loadingShow();
			$.ajax({
				method: "POST",
				url: wp.ajax_url,
				data: {
					action: 'product_filter',
					expects: expects,
					category: ProductFilter.getCategory(),
					format: ProductFilter.getFormat(),
					print: ProductFilter.getPrint(),
					paper: ProductFilter.getPaper(),
					ennoblement: ProductFilter.getEnnoblement(),
					finishing: ProductFilter.getFinishing(),
					extra: ProductFilter.getExtra(),
				}
			}).done(function (response) {
				ProductFilter.saveResponse(response);
				ProductFilter.loadingHide();
			});
		},

		/* INICIO */
		filterProduct: function () {
			$('.product-price-view').remove();
			if ('' !== ProductFilter.getCategory()) {
				ProductFilter.ajaxRequest('');
				ProductFilter.getFormatSelect().change(ProductFilter.formatChange);
				ProductFilter.getPrintSelect().change(ProductFilter.printChange);
				ProductFilter.getPaperSelect().change(ProductFilter.paperChange);
				ProductFilter.getEnnoblementSelect().change(ProductFilter.ennoblementChange);
				ProductFilter.getFinishingSelect().change(ProductFilter.finishingChange);
				ProductFilter.getExtraSelect().change(ProductFilter.extraChange);
			}
		},

		/* FORMATOS */
		loadFormat: function (formats) {
			ProductFilter.fillSelect(ProductFilter.getFormatSelect(), formats);
		},

		formatChange: function () {
			ProductFilter.clearSelect(ProductFilter.getFormatChilds());
			ProductFilter.ajaxRequest('print');
		},

		/* IMPRESSAO */
		loadPrint: function (prints) {
			ProductFilter.fillSelect(ProductFilter.getPrintSelect(), prints);
		},

		printChange: function () {
			ProductFilter.clearSelect(ProductFilter.getPrintChilds());
			ProductFilter.ajaxRequest('paper');
		},

		/* PAPEL */
		loadPaper: function (papers) {
			ProductFilter.fillSelect(ProductFilter.getPaperSelect(), papers);
		},

		paperChange: function () {
			ProductFilter.clearSelect(ProductFilter.getPaperChilds());
			ProductFilter.ajaxRequest('ennoblement');
		},

		/* ENOBRECIMENTO */
		loadEnnoblement: function (ennoblements) {
			ProductFilter.fillSelect(ProductFilter.getEnnoblementSelect(), ennoblements, true);
		},

		ennoblementChange: function () {
			ProductFilter.clearSelect(ProductFilter.getEnnoblementChilds());
			ProductFilter.ajaxRequest('acabamento');
		},

		/* ACABAMENTO */
		loadFinishing: function (finishings) {
			ProductFilter.fillSelect(ProductFilter.getFinishingSelect(), finishings, true);
		},

		finishingChange: function () {
			ProductFilter.clearSelect(ProductFilter.getFinishingChilds());
			ProductFilter.ajaxRequest('extra');
		},

		/* EXTRA */
		loadExtra: function (extras) {
			ProductFilter.clearSelect(ProductFilter.getExtraChilds());
			ProductFilter.fillSelect(ProductFilter.getExtraSelect(), extras);
		},

		extraChange: function () {
			ProductFilter.ajaxRequest('');
		},

		/* PRICES */
		loadPrices: function (prices) {

			var html = '';
			Mustache.parse(ProductFilter.product.price_view);
			for (var i = 0; i < prices.length; i++) {
				html += Mustache.render(ProductFilter.product.price_view, prices[i]);
			}
			$(' > table > tbody', ProductFilter.product.price_table).html(html);
			ProductFilter.loadingHide();
		},


		loadingShow: function () {
			var contents = ProductFilter.getLoadingContents();
			for (var i = 0; i < contents.length; i++) {
				contents[i].append('<div class="mp-loading-inner"></div>');
				contents[i].addClass('mp-loading');
			}
		},

		loadingHide: function () {
			var contents = ProductFilter.getLoadingContents();
			for (var i = 0; i < contents.length; i++) {
				$(' > .mp-loading-inner', contents[i]).remove();
				contents[i].removeClass('mp-loading');
			}
		},

		getFormatChilds: function () {
			return [
				ProductFilter.getPrintSelect(),
				ProductFilter.getPaperSelect(),
				ProductFilter.getEnnoblementSelect(),
				ProductFilter.getFinishingSelect(),
				ProductFilter.getExtraSelect(),
			];
		},
		getPrintChilds: function () {
			return [
				ProductFilter.getPaperSelect(),
				ProductFilter.getEnnoblementSelect(),
				ProductFilter.getFinishingSelect(),
				ProductFilter.getExtraSelect(),
			];
		},
		getPaperChilds: function () {
			return [
				ProductFilter.getEnnoblementSelect(),
				ProductFilter.getFinishingSelect(),
				ProductFilter.getExtraSelect(),
			];
		},
		getEnnoblementChilds: function () {
			return [
				ProductFilter.getFinishingSelect(),
				ProductFilter.getExtraSelect(),
			];
		},
		getFinishingChilds: function () {
			return [
				ProductFilter.getExtraSelect(),
			];
		},
		getExtraChilds: function () {
			return [];
		},
		getLoadingContents: function () {
			return [
				ProductFilter.filter,
				ProductFilter.product.thumbnail,
				ProductFilter.product.detail,
				ProductFilter.product.price_table
			];
		}
	};

	ProductFilter.filterProduct();
})(jQuery);
