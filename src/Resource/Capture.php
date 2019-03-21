<?php

namespace IpspPhp\Resource;

use IpspPhp\Resource;

class Capture extends Resource {
    protected $path   = '/capture/order_id';
    protected $fields = [
        'merchant_id'=>[
            'type'    => 'string',
            'required'=>TRUE
        ],
        'order_id'=>[
            'type'    => 'string',
            'required'=>TRUE
        ],
        'currency' => [
            'type' => 'string',
            'required'=>TRUE
        ],
        'amount' => [
            'type' => 'integer',
            'required'=>TRUE
        ],
        'signature' => [
            'type' => 'string',
            'required'=>TRUE
        ]
    ];
}