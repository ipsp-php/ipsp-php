<?php

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    protected static $formats;
    public static function setUpBeforeClass()
    {
        self::$formats = array(
            'json' => 'application/json',
            'xml'  => 'application/xml',
            'form' => 'application/x-www-form-urlencoded'
        );
    }
    public static function tearDownAfterClass()
    {
        self::$formats = NULL;
    }
    public function testRequest()
    {
        $request = new IpspPhp\Request();
        $this->assertInstanceOf( IpspPhp\Request::class , $request );
        return $request;
    }
    /**
     * @depends testRequest
     * @param IpspPhp\Request $request
     */
    public function testSetFormat($request)
    {
        $request->setFormat('json');
        $this->assertEquals('json',$request->getFormat());
    }
    /**
     * @depends testRequest
     * @param IpspPhp\Request $request
     */
    public function testGetContentTypes($request)
    {
        $this->assertArraySubset( self::$formats , $request->getContentTypes() );
    }
    /**
     * @depends testRequest
     * @param IpspPhp\Request $request
     */
    public function testDoPost( $request )
    {
        $this->assertEquals('',$request->doPost('_mock_',''));
        $this->assertEquals('',$request->doPost('_mock_', array()));
    }
    /**
     * @depends testRequest
     * @param IpspPhp\Request $request
     */
    public function testDoGet( $request )
    {
        $this->assertEquals( '' , $request->doGet('_mock_','') );
        $this->assertEquals( '' , $request->doGet('_mock_', array() ) );
    }
}
