<?php
namespace MisterPrint\Response;

class FreightSetOptionResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		return true;

	}
}
