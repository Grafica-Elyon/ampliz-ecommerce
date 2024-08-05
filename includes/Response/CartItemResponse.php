<?php
namespace MisterPrint\Response;

class CartItemResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		return true;
	}
}
