<?php
/**
* Plugin Name: Stackdriver Error Reporting for WordPress
* Plugin URI: https://github.com/dlackty/wp-stackdriver-error-reporting
* Description: Integrate Stackdriver Error Reporting with WordPress
* Version: 0.1.0
* Author: Richard Lee
* Author URI: https://github.com/dlackty
* License: Apache
*/
require_once __DIR__ . '/vendor/autoload.php';

use Fluent\Logger\FluentLogger;

$GLOBALS['logger'] = new FluentLogger('localhost', '24224');

function fluentd_exception_handler(Exception $e)
{
    global $logger;

    $msg = array(
        'message' => $e->getMessage(),
        'serviceContext' => array('service' => 'myapp'),
        // ... add more metadata
    );
    $logger->post('myapp.errors', $msg);
}

set_exception_handler('fluentd_exception_handler');
?>
