<?php

namespace IpspPhp\Resource;

use IpspPhp\Resource;

class Result extends Resource
{
    public function call(array $params = array() ){
        if( empty( $params ) )
        {
            $this->parseResponseData();
        } else{
            $this->setResponse($params);
        }
        return $this;
    }
    private function parseResponseData(){
       $body = file_get_contents('php://input');
       $types = $this->request->getContentTypes();
       $types = array_flip($types);
       print_r($_SERVER);
       $type = explode(';',$_SERVER['CONTENT_TYPE']);
       $type = trim($type[0]);
       if(isset($types[$type])){
           $this->format = $types[$type];
           $data = $this->parseRespose($body);
           $this->setResponse($data);
       }
    }
    public function validResponse(){
        $valid    = FALSE;
        $response = $this->getResponse();
        if( $response AND $data = $response->getData() ){
            $signature = $data['signature'];
            unset($data['signature']);
            if( array_key_exists('response_signature_string',$data))
                unset($data['response_signature_string']);
            $valid = $signature == $this->getSignature($data);
        }
        return $valid;
    }
}