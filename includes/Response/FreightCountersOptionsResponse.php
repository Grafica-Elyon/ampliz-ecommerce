<?php
namespace MisterPrint\Response;

class FreightCountersOptionsResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		return true;
	}
}
