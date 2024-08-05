<?php
namespace MisterPrint\Response;

class PaymentMethodResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		return true;
	}
}
