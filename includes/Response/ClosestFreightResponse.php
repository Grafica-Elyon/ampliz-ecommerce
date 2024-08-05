<?php
namespace MisterPrint\Response;

class ClosestFreightResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		if ( ! isset( $this->body['distancia'] ) ) {
			return false;
		}

		return true;

	}
}
