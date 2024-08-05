<?php
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_Cart extends \WPBakeryShortCode
	{
		use MisterPrint\VisualComposer\MPVisualComposer;
		public function __construct($settings)
		{
			$this->EnqueueScript('cart.js', ['jquery']);
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Cart_Totals extends \WPBakeryShortCode
	{
		use MisterPrint\VisualComposer\MPVisualComposer;

		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
}
