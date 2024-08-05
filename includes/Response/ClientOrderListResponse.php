<?php
namespace MisterPrint\Response;

class ClientOrderListResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		return true;

	}
}
