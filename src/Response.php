<?php

namespace IpspPhp;

class Response {
    private $data = array();
    public function __construct($data=array()){
        $this->data = $data;
    }
    public function __get($name){
        return isset($this->data[$name]) ? $this->data[$name] : NULL ;
    }
    public function __toString(){
        return json_encode($this->data,JSON_PRETTY_PRINT);
    }
    public function getData(){
        return $this->data;
    }
    public function redirectTo($prop=''){
        if( $this->{$prop} ){
            header(sprintf('Location: %s',$this->{$prop}));
        }
    }
    public function isSuccess(){
        return $this->__get('response_status')=='success';
    }
    public function isFailure(){
        return $this->__get('response_status')=='failure';
    }
    public function getErrorCode(){
        return $this->__get('error_code');
    }
    public function getErrorMessage(){
        return $this->__get('error_message');
    }
    public function getCheckoutUrl(){
        return $this->__get('checkout_url');
    }
    public function redirectToCheckout(){
        $this->redirectTo('checkout_url');
    }
}