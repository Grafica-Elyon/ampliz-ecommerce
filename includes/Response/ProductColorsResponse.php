<?php
namespace MisterPrint\Response;

class ProductColorsResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		return true;
	}
}
