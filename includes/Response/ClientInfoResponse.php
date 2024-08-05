<?php
namespace MisterPrint\Response;

class ClientInfoResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		if ( ! isset( $this->body['dadosCliente'] ) ) {
			return false;
		}

		return true;

	}
}
