<?php

namespace MisterPrint\Components;

class Component extends \WPBakeryShortCode
{
	protected $name;
	protected $description;
	protected $base;
	protected $params;
	protected $icon;

	function __construct($register = false)
	{
		$this->params = [];
		if ($register) {
			add_action('init', array($this, 'mapping'));
			add_shortcode($this->base, array($this, 'html'));
		}
		$this->setParams();
	}

	public function getShortcode()
	{
		return $this->base;
	}

	public function mapping()
	{
		// Stop all if VC is not enabled
		if (!defined('WPB_VC_VERSION')) {
			return;
		}

		// Map the block with vc_map()
		vc_map([
			'name' => $this->name,
			'base' => $this->base,
			'description' => $this->description,
			'show_settings_on_create' => true,
			'category' => 'Mister Print',
			'params' => $this->params,
			'icon' => $this->icon ?: (config('plugin', 'url') . 'front/assets/imgs/logo.png'),
		]);
	}

	// Element HTML
	public function html($atts)
	{
		$atts = array_merge($this->getDefaultParams(), $atts ? $atts : []);
		$this->addParams($atts);
		$hidden = "<input type='hidden' name='params' value='" . base64_encode(json_encode($atts)) . "'>";
		return '<div class="mp-component">' . $this->component() . $hidden . '</div>';
	}

	public function component()
	{
		return '<div data-component="' . $this->base . '"></div><div class="loader"></div>';
	}

	public function getParams()
	{
		return $this->params;
	}

	public function getDefaultParams()
	{
		return array_reduce($this->params, function($prev, $el){
				$prev[$el['param_name']] = $el['default'];
				return $prev;
			}, []);
	}

	public function setParams()
	{
		$this->params = [];
	}

	public function addParams($params)
	{
		$this->params = array_merge($this->params, $params);
	}

	public function getParamsAjax()
	{
		$paramters = $this->getParams();

		if (isset($_POST['params'])) {
			$params = json_decode(base64_decode($_POST['params']), true);

			foreach ($paramters as $key => $paramter) {
				if ($paramter['type'] == 'attach_image') {
					$return[$paramter['param_name']] = empty($params[$paramter['param_name']]) ? $paramter['default'] : wp_get_attachment_url($params[$paramter['param_name']]);
					continue;
				}

				$return[$paramter['param_name']] = empty($params[$paramter['param_name']]) ? $paramter['default'] : $params[$paramter['param_name']];
			}

			return $return;
		}

		return $paramters;
	}
}
