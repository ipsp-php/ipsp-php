<?php

use PHPUnit\Framework\TestCase;

class XmlDataTest extends TestCase
{

    public function testXmlData()
    {
        $xml = new IpspPhp\XmlData('<request><param>value</param></request>');
        $this->assertArrayHasKey('param',$xml->xmlToArray());
        $xml->arrayToXml( array(
            'list'=>array(
                'param'=>'value'
            )
        ));
        $this->assertArrayHasKey('list',$xml->xmlToArray());
    }

}
