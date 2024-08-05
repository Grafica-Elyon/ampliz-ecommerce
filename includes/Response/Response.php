<?php
namespace MisterPrint\Response;

use StudioVisual\Support\Components\HttpResponse;

abstract class Response extends HttpResponse
{
	public function __construct($data)
	{
		parent::__construct($data);

		if(!$this->is_valid()) {
			$this->body = 'Ocorreu um erro';
		}
	}

	public function get_data()
	{
		if(!$this->is_valid()) {
			return 'Ocorreu um erro';
		}
		return parent::get_data();
	}
}
