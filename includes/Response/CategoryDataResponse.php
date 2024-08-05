<?php
namespace MisterPrint\Response;

class CategoryDataResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		if ( ! isset( $this->body['nome'] ) ) {
			return false;
		}

		return true;

	}
}
