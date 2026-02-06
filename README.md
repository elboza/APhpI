# APhpI

## a micro PHP API router framework

### api example

```php
<?php

require '../src/APhpI.php';
use APhpI\APhpI;

// set verbose error reports ...
APhpI::set_error_handling_env("dev");

// init API router ...
$api=new APhpI;

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

```

### run test server

```sh
make run_dev
```

### exmaple test

```sh
~ % curl http://localhost:3000/api.php/echo -X POST -d 'foo' -i
HTTP/1.1 200 OK
Host: localhost:3000
Date: Mon, 28 Oct 2019 17:05:32 +0000
Connection: close
X-Powered-By: PHP/7.1.23
Content-type: text/html; charset=UTF-8

foo

~ % curl http://localhost:3000/api.php/info -i
HTTP/1.1 200 OK
Host: localhost:3000
Date: Fri, 06 Feb 2026 21:49:14 GMT
Connection: close
X-Powered-By: PHP/8.5.2
Content-type: application/json

{"headers":{"Host":"localhost:3000","User-Agent":"curl/8.18.0","Accept":"*/*"},"get_params":[],"url_params":[],"body":"","method":"GET","request_path":"/info"}

~ % curl http://localhost:3000/api.php/user -i
HTTP/1.1 200 OK
Host: localhost:3000
Date: Mon, 28 Oct 2019 17:09:44 +0000
Connection: close
X-Powered-By: PHP/7.1.23
Content-type: text/html; charset=UTF-8

404 not found

~ % curl http://localhost:3000/api.php/user/1234 -i
HTTP/1.1 200 OK
Host: localhost:3000
Date: Mon, 28 Oct 2019 17:09:50 +0000
Connection: close
X-Powered-By: PHP/7.1.23
Content-type: text/html; charset=UTF-8

your user url param is 1234 .

~ % curl http://localhost:3000/api.php/user2\?user\=1234 -i
HTTP/1.1 200 OK
Host: localhost:3000
Date: Mon, 28 Oct 2019 17:10:51 +0000
Connection: close
X-Powered-By: PHP/7.1.23
Content-type: text/html; charset=UTF-8

your user url param is 1234 .
```

