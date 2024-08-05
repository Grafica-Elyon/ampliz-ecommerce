<?php
namespace MisterPrint\Ajax;


abstract class Ajax {
	static function ajax() {
		$ajax = new static();

		return function () use ( $ajax ) {
			return $ajax->handle();
		};
	}

	abstract function handle();
}
