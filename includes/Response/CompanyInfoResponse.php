<?php
namespace MisterPrint\Response;

class CompanyInfoResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		if ( ! isset( $this->body['name'] ) ) {
			return false;
		}

		return true;

	}
}
