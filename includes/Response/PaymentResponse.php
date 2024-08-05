<?php
namespace MisterPrint\Response;

class PaymentResponse extends Response
{
	public function is_positive()
	{

		if ($this->is_valid()) {
			return true;
		}

		return false;
	}
}
