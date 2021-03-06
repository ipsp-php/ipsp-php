<?php

namespace IpspPhp\Resource;

use IpspPhp\Resource;

class PcidssConfirm extends Resource
{
    protected $path = '/3dsecure_step2';
    protected $fields = array(
        'order_id' => array(
            'type' => 'string',
            'required' => TRUE
        ),
        'merchant_id' => array(
            'type' => 'string',
            'required' => TRUE
        ),
        'pares' => array(
            'type' => 'string',
            'required' => TRUE
        ),
        'md' => array(
            'type' => 'string',
            'required' => TRUE
        ),
        'version' => array(
            'type' => 'cvv',
            'required' => FALSE
        ),
        'signature' => array(
            'type' => 'string',
            'required' => TRUE
        )
    );
}