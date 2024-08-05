<?php
namespace MisterPrint\Response;

class ProductRelatedResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		return true;
	}
}
