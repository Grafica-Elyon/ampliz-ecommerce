<?php

namespace MisterPrint\Controllers;

class CategoryController
{
	public static function configuration()
	{
		add_filter( 'query_vars', function ($query_vars){
			$query_vars[] = '29';
			return $query_vars;
		});
	}
}
