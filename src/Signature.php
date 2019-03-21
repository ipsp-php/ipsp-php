<?php

namespace IpspPhp;

class Signature {
    private $password;
    private $merchant;
    public function __construct($merchant = null ,$password = null)
    {
        $this->merchant($merchant);
        $this->password($password);
    }
    public function password($password){
        $this->password = $password;
    }
    public function merchant( $merchant ){
        $this->merchant = $merchant;
    }
    public function generate(array $params){
        $params['merchant_id'] = $this->merchant;
        $params = array_filter($params,'strlen');
        ksort($params);
        $params = array_values($params);
        array_unshift( $params , $this->password );
        $params = join('|',$params);
        return(sha1($params));
    }
    public function sign(array $params){
        if(array_key_exists('signature',$params)) return $params;
        $params['merchant_id'] = $this->merchant;
        $params['signature']   = $this->generate($params);
        return $params;
    }
    public function clean(array $data){
        if( array_key_exists('response_signature_string',$data) )
            unset( $data['response_signature_string'] );
        unset( $data['signature'] );
        return $data;
    }
    public function check(array $response){
        if(!array_key_exists('signature',$response)) return FALSE;
        $signature = $response['signature'];
        $response  = $this->clean($response);
        return $signature == $this->generate($response);
    }
}