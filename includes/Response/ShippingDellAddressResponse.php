<?php
namespace MisterPrint\Response;

class ShippingDellAddressResponse extends Response
{

	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		return true;
	}

}
