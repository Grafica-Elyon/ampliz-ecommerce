<?php
if (class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_Client_Authentication extends WPBakeryShortCodesContainer
	{
		use MisterPrint\VisualComposer\MPVisualComposer;
		public function __construct($settings)
		{
			$this->EnqueueScript('client-authentication.js', ['jquery'],
				[
					'login_success_page' => \MisterPrint\Helper\Url::getLoginSuccessUrl()
				]);
			parent::__construct($settings);
		}
	}
}


if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_Client_Authentication_User extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Client_Authentication_Pass extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
}
