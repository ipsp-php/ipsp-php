<?php

use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{

    protected static $resource;

    public static function setUpBeforeClass()
    {
        self::$resource = new IpspPhp\Resource();
    }

    public static function tearDownAfterClass()
    {
        self::$resource = null;
    }
    /**
     * @return \IpspPhp\Resource
     */
    public function testResource()
    {
        $resource = new IpspPhp\Resource();
        $this->assertInstanceOf( IpspPhp\Resource::class , $resource );
        return $resource;
    }
    /**
     * @depends testResource
     * @param IpspPhp\Resource $resource
     */
    public function testSetClient($resource)
    {
        $client = new IpspPhp\Client(900002,'test','api.fondy.eu');
        $resource->setClient($client);
        $params = $resource->getParams();
        $this->assertEquals(900002,$params['merchant_id']);
    }
    /**
     * @depends testResource
     * @param IpspPhp\Resource $resource
     * @expectedException Error
     */
    public function testSetClientException($resource)
    {
        $resource->setClient(array());
    }
    /**
     * @depends testResource
     * @param IpspPhp\Resource $resource
     */
    public function testIsValid($resource){
        $this->assertTrue($resource->isValid(array()));
    }
    /**
     * @depends testResource
     * @param IpspPhp\Resource $resource
     */
    public function testIsValidParam($resource){
        $this->assertTrue($resource->isValidParam('key','value'));
    }
    /**
     * @depends testResource
     * @param IpspPhp\Resource $resource
     */
    public function testSetParams($resource){
        $resource->setParams(array(
            'key'=>'value'
        ));
        $this->assertEquals('value',$resource->getParam('key'));
    }
    /**
     * @depends testResource
     * @param IpspPhp\Resource $resource
     */
    public function testSetParam($resource){
        $resource->setParam('key','value');
        $this->assertEquals('value',$resource->getParam('key'));
    }
    /**
     * @depends testResource
     * @param IpspPhp\Resource $resource
     */
    public function testGetParams($resource){
        $value = $resource->getParams();
        $this->assertArrayHasKey('merchant_id', $value);
        $this->assertArrayHasKey('signature', $value);
    }
    /**
     * @depends testResource
     * @param IpspPhp\Resource $resource
     */
    public function testGetParam($resource){
        $value = $resource->getParam('key');
        $this->assertEquals('value',$value);
    }


    /**
     * @depends testResource
     * @param IpspPhp\Resource $resource
     */
    public function testGetUrl($resource){
        $value = $resource->getUrl();
        $this->assertEquals('https://api.fondy.eu/api',$value);
    }

    /**
     * @depends testResource
     * @param IpspPhp\Resource $resource
     */
    public function testXMLFormat($resource){
        $resource->setFormat('xml');
        $this->assertEquals('xml',$resource->getFormat());
    }
    /**
     * @return array
     */
    public function formatProvider(){
        return array(
            'xml format'    => array('xml','xml',TRUE,'1011'),
            'json format' => array('json','json',TRUE,'1011'),
            'form encode format' => array('form','form',TRUE,'1011'),
            'undefined format' => array('custom','json',FALSE,'1011')
        );
    }
    /**
     * @dataProvider formatProvider
     * @depends testResource
     * @param $format
     * @param $formatExpected
     * @param $formatIsSet
     * @param $errorCode
     * @param IpspPhp\Resource $resource
     */
    public function testCall($format,$formatExpected,$formatIsSet,$errorCode,$resource){
        $resource->setPath('/reports');
        $setFormat = $resource->setFormat($format);
        $this->assertEquals($formatIsSet,$setFormat);
        $this->assertEquals($formatExpected,$resource->getFormat());
        $resource->call(array('param'=>'value'));
        $this->assertEquals($errorCode,$resource->getResponse()->getErrorCode());
    }
}
