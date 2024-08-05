<?php
namespace MisterPrint\Response;

class LoginResponse extends Response
{
	/**
	 * @return boolean
	 */
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}
		return $this->body['login'];

	}

	/**
	 * @param  string
	 * @param  boolean
	 * @return string
	 */
	public function get_message( $fallback, $override = false ) {

		if ( $override ) {
			return $fallback;
		}

		if ( isset( $this->body['message'] ) && ! empty( $this->body['message'] ) ) {
			return $this->body['message'];
		}

		return $fallback;
	}

	/**
	 * @return int
	 */
	public function get_id(){

		if ( isset( $this->body['id'] ) && ! empty( $this->body['id'] ) ) {
			return (int) $this->body['id'];
		}
		return 0;
	}
}
