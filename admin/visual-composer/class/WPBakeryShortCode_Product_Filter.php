<?php
if (class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_Product_Filter extends \WPBakeryShortCodesContainer
	{
		use MisterPrint\VisualComposer\MPVisualComposer;
		public function __construct($settings)
		{
			$this->EnqueueScript('product-filter.js', ['jquery']);
			parent::__construct($settings);
		}
	}
}
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_Product_Format extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Product_Print extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Product_Paper extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Product_Ennoblement extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Product_Finishing extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Product_Extra extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Product_Thumbnail extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Product_Detail extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Product_Price_Table extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
}
