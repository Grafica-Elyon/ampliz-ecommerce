<?php
namespace MisterPrint\Factory;

/**
 * Factory para Visual Composer
 * @package MisterPrint\Factory
 */
class Vc
{
	public static function paramText($name, $default)
	{
		$param_name = str_replace("(",'',from_camel_case($name));
		$param_name = str_replace(")",'',$param_name);
		return [
			'type' => 'textfield',
			'heading' => $name,
			'param_name' => $param_name,
			'default' => $default,
		];
	}
	public static function paramDropdown($name, $valores)
	{
		$param_name = str_replace("(",'',from_camel_case($name));
		$param_name = str_replace(")",'',$param_name);
		return [
			'type' => 'dropdown',
			'heading' => $name,
			'param_name' => $param_name,
			'value' => $valores,
		];
	}
	public static function paramSidebarPosition($name, $default = 'right')
	{
		$value = [
			'Direita' => 'right',
			'Esquerda' => 'left',
		];
		if($default === 'left') {
			$value = [
				'Esquerda' => 'left',
				'Direita' => 'right',
			];
		}
		return [
			'type' => 'dropdown',
			'heading' => $name,
			'param_name' => from_camel_case($name),
			'default' => $default,
			'value' => $value,
		];
	}
}
