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
use MisterPrint\BO\User;
use PSpell\Config;

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
	$debug_mode = false;
	if ($debug_mode) {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	} else {
		ini_set('display_errors', 0);
		ini_set('display_startup_errors', 0);
	}

	if (!isset($_SESSION['access_token_face']) || $_SESSION['access_token_face'] === null) {
		$code = $_GET['code'];
		if (($code != null)  && ($_SESSION['cadastroSocial'] === null)) {
			callBackFacebook();
		}
	}

	if ($_SESSION['permissionG'] == null) {
		if (!isset($_SESSION['userData_google']) || $_SESSION['userData_google'] == null) {
			$cookieGoogle = $_COOKIE['g_csrf_token'] ?? '';

			if (($_SESSION['userData_google'] == null) &&
				($_SESSION['cadastroSocial'] == null) &&
				($cookieGoogle != null)
			) {
				$_SESSION['access_token_google'] = $cookieGoogle;
				callBackGoogle();
			}
		}
	}

	$plugin = new MisterPrint();
	$plugin->run();
}
run_misterprint();


/**
 * Call back do facebook
 */
function callBackFacebook()
{
	global $FBObject;

	require_once(__DIR__ . '/front/partials/user/faceboockconfig.php');

	if (!isset($_SESSION['access_token_face']) || $_SESSION['access_token_face'] === null) {
		try {
			$accessToken = $handler->getAccessToken();
		} catch (\Facebook\Exceptions\FacebookResponseException $e) {
			echo "Response Exception: " . $e->getMessage();
			exit();
		} catch (\Facebook\Exceptions\FacebookSDKException $e) {
			echo "SDK Exception: " . $e->getMessage();
			exit();
		}

		if (!$accessToken) {
			redirect_to_page('entrar');
			exit();
		}

		$oAuth2Client = $FBObject->getOAuth2Client();
		if (!$accessToken->isLongLived())
			$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
		$response = $FBObject->get("/me?fields=id, first_name, last_name, email, picture.type(large)", $accessToken);
		$userData = $response->getGraphNode()->asArray();
		$_SESSION['userData_face'] = $userData;
		$_SESSION['access_token_face'] = (string) $accessToken;
	}


	if (isset($_SESSION['userData_face']) && is_array($_SESSION['userData_face'])) {
		if (
			isset($_SESSION['userData_face']['id']) && isset($_SESSION['userData_face']['email']) &&
			!empty($_SESSION['userData_face']['id']) && !empty($_SESSION['userData_face']['email'])
		) {

			actionloginFace($_SESSION['userData_face']['id'], $_SESSION['userData_face']['email']);
		} else {
			header('Location: login.php?error=session_data_missing');
			exit();
		}
	} else {
		header('Location: login.php?error=session_not_defined');
		exit();
	}
}

function actionloginFace($facebookId, $email)
{
	$response = (new User)->loginFacebook($facebookId);
	$redirect = "/";
	if (@$response['id']) {
		if (user()->login_user($response['id'], $email)) {
			redirect_to_page('ampliz/');
			exit();
		}
	} else {
		$_SESSION['cadastroSocial'] = 'F';
		redirect_to_page('cadastro-completo-2');
		exit();
	}
}

function redirect_to_page($page_slug)
{
	$page_url = get_page_url($page_slug);

	if (!$page_url) {
		$page_url = home_url('/');
	}

	if (!empty($args)) {
		$page_url .= '?' . http_build_query($args);
	}

	$is_home = ($page_slug === 'ampliz/');
	if ($is_home) {
		header('Location: ' . $page_url);
	} else {
		header('Location: ' . $page_url . $page_slug);
	}

	exit();
}

/**
 * Call back do google
 */
function callBackGoogle()
{
	if ($_SESSION['access_token_google'] != null) {

		$CLIENT_ID = config('env', 'APP_GOOGLE_CLIENTID');
		$client = new Google_Client(['client_id' => $CLIENT_ID]);

		//Obtém os dados do usuário com base no JWT
		$id_token = $_POST['credential'];

		if ($id_token != null) {
			$payload = $client->verifyIdToken($id_token);

			//Verifica os dados do payload
			if (isset($payload['email'])) {
				session_start();
				$_SESSION['credential_google'] = $id_token;
				$_SESSION['userData_google'] = $payload;

				actionloginGoogle($_SESSION['userData_google']['sub'], $_SESSION['userData_google']['email']);

				$_SESSION['credential_google'] = $id_token;
				$_SESSION['userData_google'] = $payload;
				//echo "<pre>";
				//print_r($payload);
				//echo "</pre>";
			}
		}
	}
}


function actionloginGoogle($googleId, $email)
{
	$response = (new User)->loginGoogle($googleId);
	$redirect = "/";
	if (@$response['id']) {
		if (user()->login_user($response['id'], $email)) {
			redirect_to_page('ampliz/');
			exit();
		}
	} else {
		$_SESSION['cadastroSocial'] = 'G';
		redirect_to_page('cadastro-completo-2');
		exit();
	}
}
