<?php
namespace MisterPrint\Ajax;

class Components extends Ajax
{
	private $component;

	public function init()
	{
		$component = isset($_POST['component']) ? $_POST['component'] : false;
		if($component) {
			$component = config('components', $component);
			$this->component = new $component();
		}
	}

	public function handle()
	{
		$this->init();

		return $this->component->render();
	}
}
