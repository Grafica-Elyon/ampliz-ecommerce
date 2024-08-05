<?php

namespace MisterPrint\Components;

use MisterPrint\Support\View;

class Header extends Component
{


	protected $name = 'Header';
	protected $description = 'Mister Print Header';
	protected $base = 'vc_mp_header';

	// Element Init
	function __construct($register = false)
	{
		if ($register) {
			add_action('init', array($this, 'mapping'));
			add_shortcode($this->base, array($this, 'html'));
		}
	}

	function render()
	{
		return (new View('header'))->get();
	}

}
