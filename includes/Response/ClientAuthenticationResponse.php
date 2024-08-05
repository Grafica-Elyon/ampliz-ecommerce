<?php
namespace MisterPrint\Response;

class ClientAuthenticationResponse extends Response
{

	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		if ( ! isset( $this->body['login'] ) ) {
			return false;
		}

		return true;

	}

	public function get_message( $fallback, $override = false ) {

		if ( $override ) {
			return $fallback;
		}

		if ( isset( $this->body['message'] ) && ! empty( $this->body['message'] ) ) {
			return $this->body['message'];
		}

		return $fallback;
	}
}
