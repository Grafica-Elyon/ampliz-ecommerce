<?php

namespace MisterPrint\BO;

use MisterPrint\Request;
use MisterPrint\Response\NewsletterResponse;

class Newsletter
{
	/**
	 * @return void
	 */
	public function registrar_newsletter($email)
	{

		$data = [
			"email" => $email
		];

		$request = new Request('newsletter/registrar-newsletter', $data);
		$response = new NewsletterResponse($request->post());


		if (!$response->is_positive()) {
			return false;
		}

		return true;
	}
}
