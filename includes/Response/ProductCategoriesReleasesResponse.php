<?php
namespace MisterPrint\Response;

class ProductCategoriesReleasesResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		return true;
	}
}
