<?php

require '../src/APhpI.php';
use APhpi\APhpi;

$api=new APhpI;

//$api->test();

$api->add_route('get','/info/:ppp/kk/:a', function($event) {
	echo "ciao info...";
	var_dump($event);
	return "pp_return";
});

$api->run();
