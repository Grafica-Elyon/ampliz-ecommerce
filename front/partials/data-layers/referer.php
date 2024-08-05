<?php
use MisterPrint\Support\View;
use MisterPrint\Support\SessionSupport;

$originReferer = SessionSupport::get('origin_referer');

if ( !$originReferer ) {
    return;
}

echo (new View('data-layers/push', [
	'customer' => [
		'referer' => $originReferer
	]
]))->get();
