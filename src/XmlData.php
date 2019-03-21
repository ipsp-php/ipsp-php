<?php

namespace IpspPhp;

use \SimpleXMLElement;

class XmlData extends SimpleXMLElement{

    public function arrayToXml($array=array()){
        foreach($array as $key=>$val) {
            if(is_numeric($key)) continue;
            if(is_array($val)) {
                $node = $this->addChild($key);
                $node->arrayToXml($val);
            } else {
                $this->addChild($key,$val);
            }
        }
    }

    public function xmlToArray(){
        $result   = array();
        $children = $this->children();
        foreach($children as $item){
            if($item->count()>0)
                $result[$item->getName()] = $item->xmlToArray();
            else
                $result[$item->getName()] = (string)$item;
        }
        return $result;
    }

}