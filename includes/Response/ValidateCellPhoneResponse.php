<?php
namespace MisterPrint\Response;

class ValidateCellPhoneResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		if ( ! isset( $this->body['sms'] ) ) {
			return false;
		}

		return true;

	}
}
