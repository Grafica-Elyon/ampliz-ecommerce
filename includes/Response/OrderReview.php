<?php
namespace MisterPrint\Response;

class OrderReview extends Response
{
	public function is_positive()
	{

		if ( ! $this->is_valid() ) {
			return false;
		}

		return true;
	}
}
