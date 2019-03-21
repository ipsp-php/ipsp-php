<?php

namespace IpspPhp\Resource;

use IpspPhp\Resource;

class Checkout extends Resource {
    protected $path   = '/checkout/url';
    protected $fields = [
        'merchant_id'=>[
            'type'    => 'string',
            'required'=>TRUE
        ],
        'order_id'=>[
            'type'    => 'string',
            'required'=>TRUE
        ],
        'order_desc'=>[
            'type' => 'string',
            'required'=>TRUE
        ],
        'currency' => [
            'type' => 'string',
            'required'=>TRUE
        ],
        'amount' => [
            'type'     => 'integer',
            'required' => TRUE
        ],
        'signature' => [
            'type' => 'string',
            'required'=>TRUE
        ]
    ];
}