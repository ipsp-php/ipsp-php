<?php

require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('IPSP_PHP_ID' , 1396424 );
define('IPSP_PHP_PASSWORD' , 'test' );
define('IPSP_PHP_GATEWAY' ,  'api.fondy.eu' );

$client   = new IpspPhp\Client( IPSP_PHP_ID , IPSP_PHP_PASSWORD, IPSP_PHP_GATEWAY );

$api      = new IpspPhp\Api( $client );

$checkout = new IpspPhp\Resource\Checkout();

$api->setParam('order_id', sprintf('order_%s',time()) );
$api->setParam('order_desc','IPSP PHP Order Description');
$api->setParam('currency', 'USD' );
$api->setParam('amount', 2000 );
$api->setParam('response_url', $api->getCurrentUrl() );

$response = $api->call($checkout)->getResponse();


print_r($response);