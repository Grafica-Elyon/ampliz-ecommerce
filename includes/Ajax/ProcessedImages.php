<?php
namespace MisterPrint\Ajax;


abstract class ProcessedImages {

    static function registerRequests ( $func ) {
        $images = [
            'loading_product',
        ];
        foreach ($images as $name) {
            $func(
                'mp_processed_image_' . $name,
                function() use ( $name ) {
                    return call_user_func(array(self::class, $name));
                }
            );
        }
    }

	static function loading_product() {

        $svgPath = realpath(__DIR__.'/../../front/assets/imgs/default-image.svg');
        $svg = file_get_contents($svgPath);

        $svg = str_replace( '#e50914', get_option('bs_publisher_theme_options')['theme_color'], $svg );

        header("Content-Type: image/svg+xml");

        echo $svg;

        exit;
	}
}
