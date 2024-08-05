<?php
if (class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_Cadastro_Incompleto extends \WPBakeryShortCodesContainer
	{
		use MisterPrint\VisualComposer\MPVisualComposer;
		public function __construct($settings)
		{
			$this->EnqueueScript('cadastro-incompleto.js', ['jquery']);
			parent::__construct($settings);
		}
	}
}

if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_Cadastro_Incompleto_Nome extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Cadastro_Incompleto_Email extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Cadastro_Incompleto_Telefone extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Cadastro_Incompleto_Profissao extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Cadastro_Incompleto_Cep extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
	class WPBakeryShortCode_Cadastro_Incompleto_Como_Conheceu extends \WPBakeryShortCode
	{
		public function __construct($settings)
		{
			parent::__construct($settings);
		}
	}
}
