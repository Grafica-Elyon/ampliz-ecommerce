<?php
namespace MisterPrint\Response;

class ProductFormatsResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		return true;
	}
}
