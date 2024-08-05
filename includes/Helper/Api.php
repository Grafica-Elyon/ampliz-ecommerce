<?php
namespace MisterPrint\Helper;

use MisterPrint\BO\Cliente;
use MisterPrint\BO\Frete;

class Api
{
	public static function cep()
	{
		return function () {
			$user = new Cliente();
			return $user->auto_completar_endereco($_POST['data']);
		};
	}

	public static function cacheClear() {
		return function() {
			global $wpdb;
			$sql = 'DELETE FROM ' . $wpdb->options . ' WHERE option_name LIKE "_transient_%"';
			$wpdb->query($sql);
			return true;
		};
	}

	public function updateBalconiesMap()
    {
		return function () {
            global $wpdb;
            $table = $wpdb->prefix . 'mapmarker_marker';

            $boFrete = new Frete();
            $fretes = $boFrete->get_opcoes_balcoes( -1, null );
            $fretes = $fretes['todos'];

            $markerId = 2;

            $wpdb->query(
                $wpdb->prepare(
                    "DELETE FROM $table WHERE marker_id = %d",
                    [$markerId]
                )
            );

            foreach ( $fretes as $f ) {
                $wpdb->query(
                    $wpdb->prepare(
                        "INSERT INTO $table(marker_id,titre,description,adresse,telephone,weblink,img_desc_marker,img_icon_marker,latitude,longitude) VALUE( %d, %s, %s, %s, %s, %s, %d, %d, %s, %s )",
                        [
                            $markerId,
                            $f['titulo'].' - '.$f['codigo'],
                            implode("\n", [
                                "Código: {$f['codigo']}",
                                $f['detalhe'],
                                'Valor: '. (floatval( $f['valor'] ) ? number_format(floatval( $f['valor'] ), 2, ',', '.') : 'Grátis')
                            ]),
                            $f['detalhe'],
                            0,
                            '',
                            '',
                            '',
                            $f['latitude'],
                            $f['longitude']
                        ]
                    )
                );
            }

            return true;
		};
	}
}
