<?php

use PHPUnit\Framework\TestCase;

final class ApiTest extends TestCase
{
    protected $params;
    /**
     * @before
     */
    public function setupProperties()
    {
        $this->params = [
            'params_key'   => 'order_desc',
            'params_value' => 'Test Order Description',
        ];
    }
    /**
     * @after
     */
    public function cleanProperties()
    {
        $this->params = null;
    }

    /**
     * @return IpspPhp\Client
     */
    public function testInitClient(){
        $client = new IpspPhp\Client( 1000 , 'test', 'api.fondy.eu' );
        $this->assertInstanceOf( IpspPhp\Client::class , $client );
        return $client;
    }
    /**
     * @depends testInitClient
     * @param IpspPhp\Client $client
     * @return IpspPhp\Api $api
     */
    public function testInitApi( $client ){
        $api    = new IpspPhp\Api( $client );
        $this->assertInstanceOf( IpspPhp\Api::class , $api );
        return $api;
    }
    /**
     * @depends testInitApi
     * @param IpspPhp\Api $api
     */
    public function testInitResourceSuccess( $api )
    {
        $checkout = new IpspPhp\Resource\Checkout();
        $this->assertInstanceOf( IpspPhp\Resource\Checkout::class , $checkout );
    }
    /**
     * @depends testInitApi
     * @param IpspPhp\Api $api
     */
    public function testCallSuccess( $api ){
        $result = new IpspPhp\Resource\Result();
        $response = $api->call($result,array('prop'=>'value'));
        $this->assertInstanceOf( IpspPhp\Resource\Result::class , $response );
    }
    /**
     * @depends testInitApi
     * @backupGlobals enabled
     * @param IpspPhp\Api $api
     */
    public function testGetCurrentUrl( $api ){
        $_SERVER['HTTP_HOST'] = 'example.com';
        $_SERVER['SERVER_PORT'] = '';
        $_SERVER['REQUEST_URI'] = '/';
        $this->assertEquals('http://example.com/',$api->getCurrentUrl());
        $_SERVER['HTTP_HOST'] = NULL;
        $this->assertEquals('http://localhost/',$api->getCurrentUrl());
    }
    /**
     * @depends testInitApi
     * @backupGlobals enabled
     * @param IpspPhp\Api $api
     */
    public function testHasAcsData( $api ){
        $_POST['MD'] = 'test_md';
        $_POST['PaRes'] = 'test_pa_res';
        $this->assertTrue($api->hasAcsData());
    }

    /**
     * @depends testInitApi
     * @backupGlobals enabled
     * @param IpspPhp\Api $api
     */
    public function testHasResponseStatus( $api ){
        $_POST['response_status'] = 'success';
        $this->assertTrue($api->hasResponseData());
    }
    /**
     * @depends testInitApi
     * @param IpspPhp\Api $api
     */
    public function testSetGetParam( $api ){
        $key   = $this->params['params_key'];
        $value = $this->params['params_value'];
        $api->setParam($key,$value);
        $this->assertEquals( $value , $api->getParam($key) );
    }
}