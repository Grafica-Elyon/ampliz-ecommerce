<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://studiovisual.com.br
 * @since             1.0.0
 * @package           MisterPrint
 *
 * @wordpress-plugin
 * Plugin Name:       Mister Print
 * Plugin URI:        http://studiovisual.com.br
 * Description:       Integração com a API do e-commerce Mr. Print.
 * Version:           1.3.9
 * Author:            Studio Visual
 * Author URI:        http://studiovisual.com.br
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       misterprint-ecommerce
 * Domain Path:       /languages
 */
use MisterPrint\MisterPrint;

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/Activator.php
 */
function activate_misterprint()
{
	require_once plugin_dir_path(__FILE__) . 'includes/Core/Activator.php';
	\MisterPrint\Core\Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/Deactivator.php
 */
function deactivate_misterprint()
{
	require_once plugin_dir_path(__FILE__) . 'includes/Core/Deactivator.php';
	\MisterPrint\Core\Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_misterprint');
register_deactivation_hook(__FILE__, 'deactivate_misterprint');

/**
 * Autoload
 */
require_once plugin_dir_path(__FILE__)  . 'vendor/autoload.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_misterprint()
{
	date_default_timezone_set('America/Sao_Paulo');
	$debug_mode = config('plugin','debug');
	if ($debug_mode) {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	} else {
		ini_set('display_errors', 0);
		ini_set('display_startup_errors', 0);
	}

	$plugin = new MisterPrint();
	$plugin->run();
}
run_misterprint();