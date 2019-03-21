<?php

namespace IpspPhp\Resource;
use IpspPhp\Resource;

class Reverse extends Resource
{

    protected $path = '/reverse/order_id';

    protected $fields = array(
        'merchant_id' => array(
            'type' => 'string',
            'required' => TRUE
        ),
        'order_id' => array(
            'type' => 'string',
            'required' => TRUE
        ),
        'currency' => array(
            'type' => 'string',
            'required' => TRUE
        ),
        'amount' => array(
            'type' => 'integer',
            'required' => TRUE
        ),
        'signature' => array(
            'type' => 'string',
            'required' => TRUE
        ),
        'version' => array(
            'type' => 'string',
            'required' => FALSE
        )
    );

}