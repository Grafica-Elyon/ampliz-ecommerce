<?php
namespace MisterPrint\Response;

class NewsletterResponse extends Response
{
	/**
	 * @return boolean
	 */
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}
		return true;

	}
}
