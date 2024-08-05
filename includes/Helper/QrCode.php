<?php
namespace MisterPrint\Helper;

use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode as EndroidGenerator;

use MisterPrint\BO\Cliente;
use MisterPrint\BO\Frete;

class QrCode
{
	public static function generate() {
		return function () {
			$qrCode = new EndroidGenerator($_GET['text']);

			if ( @$_GET['qrlabel'] ) {
				$labelSize = @$_GET['label_size'] ?: 16;
				$qrCode->setLabel(
					$_GET['qrlabel'],
					intval($labelSize),
					__DIR__.'/../../vendor/endroid/qr-code/assets/fonts/open_sans.ttf',
					LabelAlignment::CENTER()
				);
			}

			header('Content-Type: '.$qrCode->getContentType());
			echo $qrCode->writeString();
			exit();
		};
	}
}
