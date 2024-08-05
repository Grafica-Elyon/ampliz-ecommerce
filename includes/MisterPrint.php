<?php

namespace MisterPrint;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * front-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    MisterPrint
 * @subpackage MisterPrint/includes
 */

use Brain\Cortex;
use Carbon\Carbon;
use MisterPrint\Admin\Admin;
use MisterPrint\Components\Header;
use MisterPrint\Core\I18n;
use MisterPrint\Core\Loader;
use MisterPrint\Front\Front;
use MisterPrint\Support\View;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * front-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    MisterPrint
 * @subpackage MisterPrint/includes
 * @author     Your Name <email@example.com>
 */

class MisterPrint
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	protected $plugin_path;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	protected $config;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the front-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		$this->plugin_name = \config('plugin', 'name');
		$this->version = \config('plugin', 'version');
		$this->plugin_path = \config('plugin', 'path');
		$this->loader = new Loader();

		Cortex::boot();
		Carbon::setLocale('pt_BR');

		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new I18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Admin($this->get_plugin_name(), $this->get_version());
		$plugin_admin->register_components();
		$plugin_admin->register_ajax();
		$plugin_admin->register_posts();
		$plugin_admin->register_pages();

		$this->loader->add_filter('template_include', $plugin_admin, 'blank_page_template', 99);
		$this->loader->add_filter('locale', $plugin_admin, 'set_locale');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		$this->loader->add_action('init', $plugin_admin, 'register_products' );
	}

	/**
	 * Register all of the hooks related to the front-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Front($this->get_plugin_name(), $this->get_version(), $this->get_plugin_path());

		// $plugin_public->define_routes();

		$this->loader->add_action('init', $plugin_public, 'define_routes');
		$this->loader->add_action('pre_get_posts', $plugin_public, 'prefix__pre_get_posts');
		$this->loader->add_action('parse_query', $plugin_public, 'parse_paramns');
		$this->loader->add_action('cortex.routes', $plugin_public, 'routes');
		$this->loader->add_action('wp', $plugin_public, 'requests');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		$this->loader->add_action('wp_head', $plugin_public, 'getHeader');
		$this->loader->add_action('wp_head', $plugin_public, 'registerRefererSession');

		$this->loader->add_filter('query_vars', $plugin_public, 'add_query_vars');
		$this->loader->add_filter('wp_nav_menu_items', $plugin_public, 'custom_main_menu', 10, 2);
		$this->loader->add_filter('walker_nav_menu_start_el', $plugin_public, 'prefix_nav_description', 10, 4);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}

	public function get_plugin_path()
	{
		return $this->plugin_path;
	}
}
