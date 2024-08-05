<?php

$components = config('components');

if ( isset($components[$this->data]) ) {
	echo '<div class="mp-component">'. (new $components[$this->data]())->component() .'</div>';
	return;
}
