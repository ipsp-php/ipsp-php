<h1 align="center">
  <a href="https://ipsp-php.com"><img src="https://raw.githubusercontent.com/kosatyi/ipsp-php/gh-pages/assets/images/brand.png" alt="IPSP PHP (SDK)" width="201" height="193"></a>
  <br>
  IPSP PHP SDK
  <br>
</h1>

<h4 align="center">
Flexible software development kit that covers e-commerce for businesses of all types and support
popular CMS modules for fast integration in existing infrastructure.
</h4>

<p align="center">
<a href="https://packagist.org/packages/ipsp-php/ipsp-php"><img src="https://poser.pugx.org/ipsp-php/ipsp-php/version" /></a>
<a href="https://travis-ci.org/ipsp-php/ipsp-php"><img src="https://img.shields.io/travis/ipsp-php/ipsp-php.svg" /></a>
<a href="https://coveralls.io/github/ipsp-php/ipsp-php"><img src="https://img.shields.io/coveralls/ipsp-php/ipsp-php/master.svg" /></a>
<a href="https://packagist.org/packages/ipsp-php/ipsp-php"><img src="https://poser.pugx.org/ipsp-php/ipsp-php/downloads"/></a>
<a href="https://packagist.org/packages/ipsp-php/ipsp-php"><img src="https://poser.pugx.org/ipsp-php/ipsp-php/license" /></a>
</p>
<p align="center">
<a href="https://ipsp-php.com/"><img src="https://img.shields.io/badge/official-website-green.svg" /></a>
<a href="https://ipsp-php.com/docs/"><img src="https://img.shields.io/badge/sdk-documentation-orange.svg" /></a>
<a href="https://ipsp-php.com/docs/api-methods/"><img src="https://img.shields.io/badge/api-methods-blue.svg" /></a>
</p>
<p align="center">
<a href="https://ipsp-php.com"><img src="https://i.imgur.com/7pZYzfV.png" alt="Checkout Page Example PHP (SDK)"></a>
</p>

## Installation

### System Requirements

PHP 7.1 and later.

### Dependencies

SDK require the following extension in order to work properly:

- [`curl`](https://secure.php.net/manual/en/book.curl.php)
- [`json`](https://secure.php.net/manual/en/book.json.php)

### Composer

If you’re using [Composer](https://getcomposer.org/), you can run the following command:

```cmd
composer require kosatyi/ipsp-php
```

Or add dependency manually in `composer.json`

```json
{
  "require": {
    "ipsp-php/ipsp-php":"dev-master"
  }
}
```

## Quick Start

Import library to your project file.

```php
<?php
// If you are install SDK with composer
require_once 'vendor/autoload.php';
```

Define constants in project file or import from custom location.

```php
<?php
define('MERCHANT_ID' , 'your_merchant_id');
define('MERCHANT_PASSWORD' , 'password');
define('IPSP_GATEWAY' , 'your_ipsp_gateway');
```

Create `IpspPhp\Client` instance by passing configuration properties:

- `IPSP_PHP_ID` - Checkout Merchant ID from provider admin panel.
- `IPSP_PHP_PASSWORD` - Merchant password
- `IPSP_PHP_GATEWAY` - Choose provider gateway.

```php
<?php
$client = new IpspPhp\Client( IPSP_PHP_ID , IPSP_PHP_PASSWORD, IPSP_PHP_GATEWAY );
```

Create `IpspPhp\Api` instance by passing `IpspPhp\Client` instance:

```php
<?php
$ipsp   = new IpspPhp\Api( $client );
```

Finally create bootstrap file `init.php` with content below:

```php
<?php
require_once 'vendor/autoload.php';
define('IPSP_PHP_ID' , 'YOUR_MERCHANT_ID');
define('IPSP_PHP_PASSWORD' , 'PAYMENT_KEY' );
define('IPSP_PHP_GATEWAY' , 'api.fondy.eu');
$client = new IpspPhp\Client( IPSP_PHP_ID , IPSP_PHP_PASSWORD, IPSP_PHP_GATEWAY );
$ipsp   = new IpspPhp\Api( $client );
```

## Basic Usage Example

```php
<?php
require_once('path/to/init.php');
$checkout = new IpspPhp\Resource\Checkout();
$data = $ipsp->call($checkout,[
  'order_id'    => 'orderid-111222333',
  'order_desc'  => 'Simple checkout page',
  'currency'    => $ipsp::USD ,
  'amount'      => 2000, // 20 USD
  'response_url'=> sprintf('http://shop.example.com/result.php')
])->getResponse();
// redirect to checkout page
$data->redirectToCheckout();
```

## Handling response

Create page `result.php` with code below:

```php
<?php
require_once('path/to/init.php');
$result = new IpspPhp\Resource\Result();
$response = $api->call($result);
if( $response->validResponse() ){
    exit(sprintf('<pre>%s</pre>',$result->getResponse()));
}
```

## Follow project on:

- Facebook [/ipsp.sdk](https://facebook.com/ipsp.sdk/)
- Twitter [@ipspsdk](https://twitter.com/ipspsdk)

## Author

Stepan Kosatyi, stepan@kosatyi.com

[![Stepan Kosatyi](https://img.shields.io/badge/stepan-kosatyi-purple.svg)](https://kosatyi.com/)
