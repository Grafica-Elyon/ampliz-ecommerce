<?php

namespace MisterPrint\Admin;

class SettingsDefaultPages
{
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $default_pages;

	/**
	 * Start up
	 */
	public function __construct()
	{
		// Set class property
		$this->default_pages = get_option( 'opt_default_pages' );
		add_action( 'admin_menu', array( $this, 'setSettingsDefaultPages' ) );
		add_action( 'admin_init', array( $this, 'initSettingsDefaultPages' ) );
		//add_action( 'admin_enqueue_scripts', array( $this, 'initAssetsSettingsDefaultPages' ) );
	}
	/**
	 * Add Assets files like .js .css
	 * @param $hook
	 */
	function initAssetsSettingsDefaultPages($hook) {
	   if('toplevel_page_settings-default-pages' == $hook){

	   }
	}
	/**
	 * Add options page
	 */
	public function setSettingsDefaultPages()
	{

		add_menu_page('Mister Print', 'Mister Print', 'manage_options', 'settings-default-pages', array( $this, 'printSettingsDefaultPages' ) );
		add_submenu_page('settings-default-pages', 'Configurações', 'Configurações', 'manage_options', 'settings-default-pages' );
		add_submenu_page('settings-default-pages', 'Configurações 2', 'Configurações 2', 'manage_options', 'settings-default-pages-2' );
	}

	/**
	 * Options page callback
	 */
	public function printSettingsDefaultPages()
	{
		?>
		<div class="wrap">
			<h1>Mister Print - Definição de Páginas</h1>
			<form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields( 'grp_default_pages' );
				do_settings_sections( 'settings-default-pages' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function initSettingsDefaultPages()
	{
		register_setting(
			'grp_default_pages', // Option group
			'opt_default_pages', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'setting_section_id', // ID
			'Defina as Páginas do sistema.', // Title
			array( $this, 'printSectionInfo' ), // Callback
			'settings-default-pages' // Page
		);

		add_settings_field(
			'login_page', // ID
			'Login', // Title
			array( $this, 'printLoginPageSection' ), // Callback
			'settings-default-pages', // Page
			'setting_section_id' // Section        add_action( 'admin_init', array( $this, 'initSettingsDe
		);
		add_settings_field(
			'login_success_page', // ID
			'Login Sucesso', // Title
			array( $this, 'printLoginSuccessPageSection' ), // Callback
			'settings-default-pages', // Page
			'setting_section_id' // Section        add_action( 'admin_init', array( $this, 'initSettingsDe
		);
		add_settings_field(
			'shop_page',
			'Loja',
			array( $this, 'printShopPageSection' ),
			'settings-default-pages',
			'setting_section_id'
		);

		add_settings_field(
			'cart_page',
			'Carrinho',
			array( $this, 'printCartPageSection' ),
			'settings-default-pages',
			'setting_section_id'
		);

		add_settings_field(
			'checkout_page',
			'Checkout',
			array( $this, 'printCheckoutPageSection' ),
			'settings-default-pages',
			'setting_section_id'
		);

		add_settings_field(
			'cad_comp_page',
			'Cadastro Completo',
			array( $this, 'printCadCompletePageSection' ),
			'settings-default-pages',
			'setting_section_id'
		);

		add_settings_field(
			'cad_no_comp_page',
			'Cadastro Incompleto',
			array( $this, 'printCadNoCompletePageSection' ),
			'settings-default-pages',
			'setting_section_id'
		);
	}

	/**
	 * Sanitize each setting field as needed
	 * Save the options
	 * @param $input : contains all settings fields as array keys
	 * @return array : Option name opt_default_pages
	 */
	public function sanitize( $input )
	{
		$return_input = array();
		if( isset( $input['login_page'] ) )
			$return_input['login_page'] = sanitize_text_field( $input['login_page'] );

		if( isset( $input['login_success_page'] ) )
			$return_input['login_success_page'] = sanitize_text_field( $input['login_success_page'] );

		if( isset( $input['shop_page'] ) )
			$return_input['shop_page'] = sanitize_text_field( $input['shop_page'] );

		if( isset( $input['cart_page'] ) )
			$return_input['cart_page'] = sanitize_text_field( $input['cart_page'] );

		if( isset( $input['checkout_page'] ) )
			$return_input['checkout_page'] = sanitize_text_field( $input['checkout_page'] );

		if( isset( $input['cad_comp_page'] ) )
			$return_input['cad_comp_page'] = sanitize_text_field( $input['cad_comp_page'] );

		if( isset( $input['cad_no_comp_page'] ) )
			$return_input['cad_no_comp_page'] = sanitize_text_field( $input['cad_no_comp_page'] );

		return $return_input;
	}

	/**
	 * Print the Section text
	 */
	public function printSectionInfo()
	{
		print 'Especifique qual página corresponde como a página padrão para o sistema:';
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function printLoginPageSection()
	{
		echo $this->createSelectPages('login_page');
	}
	/**
	 * Get the settings option array and print one of its values
	 */
	public function printLoginSuccessPageSection()
	{
		echo $this->createSelectPages('login_success_page');
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function printShopPageSection()
	{
		echo $this->createSelectPages('shop_page');
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function printCartPageSection()
	{
		echo $this->createSelectPages('cart_page');
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function printCheckoutPageSection()
	{
		echo $this->createSelectPages('checkout_page');
	}
	/**
	 * Get the settings option array and print one of its values
	 */
	public function printCadCompletePageSection()
	{
		echo $this->createSelectPages('cad_comp_page');
	}
	/**
	 * Get the settings option array and print one of its values
	 */
	public function printCadNoCompletePageSection()
	{
		echo $this->createSelectPages('cad_no_comp_page');
	}
	/**
	 * Print select HTML element to relational page
	 * @param $select_id
	 * @return string : HTML Select element
	 */
	public function createSelectPages($select_id){

		$select = '<select id="' . $select_id . '" name="opt_default_pages['. $select_id .']">';
		$select .= '<option value="">' . esc_attr( __( 'Selecione a página' ) ) . '</option>';
		$pages = get_pages();

		foreach ( $pages as $page ) {
			$select .= '<option value="' . $page->ID . '"' . ($this->default_pages[$select_id] == $page->ID ? 'selected' : '') . '>';
			$select .= $page->post_title;
			$select .= '</option>';
		}
		$select .= '</select>';

		return $select;
	}

}

if( is_admin() ) {
	new SettingsDefaultPages();
}
