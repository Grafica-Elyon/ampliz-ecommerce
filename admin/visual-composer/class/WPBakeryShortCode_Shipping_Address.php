<?php
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_Shipping_Address extends \WPBakeryShortCode
	{
		use MisterPrint\VisualComposer\MPVisualComposer;
		public function __construct($settings)
		{
			$this->EnqueueScript('shipping-address.js', ['jquery']);
			parent::__construct($settings);
		}
	}
}
