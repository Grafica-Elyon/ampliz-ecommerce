<?php
namespace MisterPrint\Response;

class ProductCategoriesOffersResponse extends Response
{
	public function is_positive() {

		if ( ! $this->is_valid() ) {
			return false;
		}

		return true;
	}
}
