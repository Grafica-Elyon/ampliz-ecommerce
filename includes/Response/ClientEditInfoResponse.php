<?php
namespace MisterPrint\Response;

class ClientEditInfoResponse extends Response
{
	public function is_positive() {
		return $this->is_valid();
	}
}
