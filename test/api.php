<?php

require '../src/APhpI.php';
use APhpi\APhpi;

$api=new APhpI;

$api->set_debug_true();

//$api->test();

$api->add_route('get','/info/:ppp/kk/:a', function($event) {

	pippo();
	return array(
		'statusCode'=>400,
		'headers'=> array(
			'Content-type'=>'application/json'
		),
		'body'=>var_export($event, true)
	);
});

$api->run();
