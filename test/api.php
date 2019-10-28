<?php

require '../src/APhpI.php';
use APhpi\APhpi;

$api=new APhpI;

$api->set_debug_true();

//$api->test();

$api->add_route('get','/info', function($event) {
	return array(
		'statusCode'=>200,
		'headers'=> array(
			'Content-type'=>'application/json'
		),
		'body'=>var_export($event, true)
	);
});

$api->add_route('post','/echo', function($event) {
	return array(
		'statusCode'=> 200,
		'body'=> $event['body']
	);
});

$api->add_route('get','/user/:user', function($event) {
	$user=$event['url_params']['user'];
	return [
		'statusCode'=>200,
		'body'=> "your user url param is $user ."
	];
});

$api->add_route('get','/user2', function($event) {
	$user=$event['get_params']['user'];
	return [
		'statusCode'=>200,
		'body'=> "your user url param is $user ."
	];
});

$api->run();
