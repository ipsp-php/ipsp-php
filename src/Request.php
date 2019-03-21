<?php

namespace IpspPhp;

class Request {
    private $curl;
    private $format;
    private $contentType = array(
        'json' => 'application/json',
        'xml'  => 'application/xml',
        'form' => 'application/x-www-form-urlencoded'
    );
    public function __construct(){
        $this->curl = new Curl;
    }
    public function setFormat($format){
        $this->format = $format;
        return $this;
    }
    public function getFormat(){
        return $this->format;
    }
    private function getContentType($format){
        $type = $this->contentType[$format];
        return  sprintf('Content-Type: %s',$type);
    }
    private function getParamsQuery($params=array()){
        if( is_array( $params ) )
            $params = http_build_query($params, NULL, '&');
        return $params;
    }
    public function getContentTypes(){
        return $this->contentType;
    }
    private function getContentLength($str=''){
        return sprintf('Content-Length: %s',strlen($str));
    }
    public function doPost( $url = '' , $params=array()){
        $params = $this->getParamsQuery($params);
        $this->curl->create($url);
        $this->curl->option(CURLOPT_SSL_VERIFYPEER, TRUE );
        $this->curl->option(CURLOPT_SSL_VERIFYHOST, 2 );
        $this->curl->post( $params );
        $this->curl->http_header( $this->getContentType( $this->format ));
        $this->curl->http_header( $this->getContentLength( $params ));
        return $this->curl->execute();
    }
    public function doGet( $url='' , $params=array() ){
        $params = $this->getParamsQuery($params);
        $this->curl->create($url.( empty( $params ) ? '' : '?'.$params ));
        $this->curl->option(CURLOPT_SSL_VERIFYPEER, TRUE );
        $this->curl->option(CURLOPT_SSL_VERIFYHOST, 2 );
        $this->curl->http_header( $this->getContentType( $this->format ) );
        $this->curl->http_header( $this->getContentLength( $params ) );
        return $this->curl->execute();
    }
}
