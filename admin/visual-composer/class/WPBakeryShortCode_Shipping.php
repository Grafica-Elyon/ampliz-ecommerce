<?php
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_Shipping extends \WPBakeryShortCode
	{
		use MisterPrint\VisualComposer\MPVisualComposer;
		public function __construct($settings)
		{
			$this->EnqueueScript('shipping.js', ['jquery']);
			parent::__construct($settings);
		}
	}
}
