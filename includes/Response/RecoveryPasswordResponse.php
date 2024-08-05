<?php
namespace MisterPrint\Response;

class RecoveryPasswordResponse extends Response
{

	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		if ( ! isset( $this->body['emailExiste'] ) ) {
			return false;
		}

		if ( 'true' === $this->body['emailExiste'] ) {
			return true;
		}

		return false;

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
