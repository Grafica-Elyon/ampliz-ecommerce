import mp_newsletter from './components/mp-newsletter';
import mp_categories from './components/mp-categories';
import mp_categories_featured from './components/mp-categories-featured';
import mp_category from './components/mp-category';
import mp_category_configuration from './components/mp-category-configuration';
import mp_login from './components/mp-login';
import mp_cart from './components/mp-cart';
import mp_checkout_shipping from './components/mp-checkout-shipping';
import mp_panel_addresses from './components/mp-panel-addresses';
import mp_panel_data from './components/mp-panel-data';
import mp_panel_orders from './components/mp-panel-orders';
import mp_graphic_production from './components/mp-graphic-production';
import mp_incomplete_register from './components/mp-incomplete-register';
import mp_login_social from './components/mp-login-social';
import mp_checkout_complete from './components/mp-checkout-complete';
import mp_register from './components/mp-register';
import checkout_billing from './components/mp-checkout-billing';
import mp_header from './components/mp-header';
import mp_send_art from './components/mp-send-art';
import mp_creation_form from './components/mp-creation-form';
import mp_preview_art from './components/mp-preview-art';
import mp_conta_corrente from './components/mp-conta-corrente';
import mp_balcony_payment from './components/mp-balcony-payment';
import mp_balcony_dispatch from './components/mp-balcony-dispatch';
import mp_balcony_print from './components/mp-balcony-print';
import mp_balcony_art_creation from './components/mp-balcony-art-creation';
import mp_password_recovery from './components/mp-password-recovery';
import mp_panel_favorites from './components/mp-panel-favorites';
import mp_subcategories from './components/mp-subcategories';
import mp_lista_fretes from './components/mp-lista-fretes';
import mp_coupon from './components/mp-coupon';
import mp_button from './components/mp-button';

export default class Scripts {
	constructor() {
		this.components = {
			'vc_mp_categories': mp_categories,
			'vc_mp_categories_featured': mp_categories_featured,
			'vc_mp_newsletter': mp_newsletter,
			'vc_mp_category': mp_category,
			'vc_mp_category_configuration': mp_category_configuration,
			'vc_mp_login': mp_login,
			'vc_mp_cart': mp_cart,
			'vc_mp_checkout_shipping': mp_checkout_shipping,
			'vc_mp_panel_addresses': mp_panel_addresses,
			'vc_mp_panel_data': mp_panel_data,
			'vc_mp_panel_orders': mp_panel_orders,
			'vc_mp_graphic_production': mp_graphic_production,
			'vc_mp_incomplete_register': mp_incomplete_register,
			'vc_mp_login_social': mp_login_social,
			'vc_mp_checkout_complete': mp_checkout_complete,
			'vc_mp_register': mp_register,
			'vc_mp_checkout_billing': checkout_billing,
			'vc_mp_send_art': mp_send_art,
			'vc_mp_creation_form': mp_creation_form,
			'mp_preview_art': mp_preview_art,
			'vc_mp_panel_conta_corrente': mp_conta_corrente,
			'mp_balcony_payment': mp_balcony_payment,
			'mp_balcony_dispatch': mp_balcony_dispatch,
			'mp_balcony_print': mp_balcony_print,
			'mp_balcony_art_creation': mp_balcony_art_creation,
			'vc_mp_recovery_password': mp_password_recovery,
			'vc_mp_panel_favorites': mp_panel_favorites,
			'vc_mp_subcategories': mp_subcategories,
			'vc_mp_lista_fretes': mp_lista_fretes,
			'mp_coupon': mp_coupon,
			'mp_button': mp_button,
		};

		if ($('.mp-header').length) {
			mp_header();
		}
	}

	load(el) {
		let component = $(el).data('component');
		this.components[component](el);
	}
}
