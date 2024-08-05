<?php
namespace MisterPrint\Response;

class OrderResponse extends Response
{
	public function is_positive()
	{

		if ( ! $this->is_valid() ) {
			return false;
		}

		return true;
	}
}
