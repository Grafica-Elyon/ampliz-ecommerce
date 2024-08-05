<?php
namespace MisterPrint\VisualComposer;

Trait MPVisualComposer
{
	function EnqueueScript ($file, $dependencies = [], $data = [], $ver = '1.0.0') {
		if(!is_admin()) {
			wp_enqueue_script($file, plugins_url(MISTERPRINT_PLUGIN_NAME) . '/front/js/' . $file, $dependencies, $ver, true);
			$data_vars = [
				'ajax_url' => admin_url('admin-ajax.php'),
				'view_path' => plugins_url(PLUGIN_NAME) . '/front/js/view/'
			];
			$data = array_merge($data_vars, $data);
			wp_localize_script( $file, 'wp', $data);
		}
	}
}
