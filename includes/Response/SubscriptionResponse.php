<?php
namespace MisterPrint\Response;

class SubscriptionResponse extends Response
{

	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		if ( ! isset( $this->body['response'] ) ) {
			return false;
		}

		if ( 'success' !== $this->body['response'] ) {
			return false;
		}

		if ( 'error' === $this->body['response'] ) {
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
