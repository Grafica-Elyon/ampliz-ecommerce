<?php
namespace MisterPrint\Response;

class RegisterOrderResponse extends Response
{
	public function is_positive()
	{

		if ($this->is_valid()) {
			return true;
		}

		return false;
	}
}
