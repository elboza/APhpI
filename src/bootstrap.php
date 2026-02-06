<?php
function set_error_handling_env($env) {
	if($env=="DEV" || $env=="dev") {
		$isDev=true;
	} else {
		$isDev=false;
	}
error_reporting(E_ALL);
ini_set('display_errors', $isDev ? '1' : '0');
ini_set('display_startup_errors', $isDev ? '1' : '0');
ini_set('log_errors', '0');
ini_set('error_log', __DIR__ . '/php-error.log');
set_error_handler(function ($severity, $message, $file, $line) {
    // Respect error_reporting() level
    if (!(error_reporting() & $severity)) {
        return false;
    }

    throw new ErrorException($message, 0, $severity, $file, $line);
});
set_exception_handler(function (Throwable $e) use ($isDev) {
    error_log($e);

    http_response_code(500);

    if ($isDev) {
        echo "<pre style='color:red; font-family:monospace'>";
        echo $e;
        echo "</pre>";
    } else {
        echo "Internal Server Error";
    }
});
register_shutdown_function(function () use ($isDev) {
    $error = error_get_last();

    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        error_log(print_r($error, true));

        http_response_code(500);

        if ($isDev) {
            echo "<pre style='color:red; font-family:monospace'>";
            print_r($error);
            echo "</pre>";
        } else {
            echo "Internal Server Error";
        }
    }
});
}

// set prd env by default ...
set_error_handling_env("prd");
//set_error_handling_env("dev");
