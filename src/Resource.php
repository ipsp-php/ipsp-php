<?php

namespace IpspPhp;

class Resource {

    protected $method = 'POST';
    protected $defaultFormat = 'json';
    protected $format = 'json';
    protected $path;
    protected $fields = array();
    protected $defaultParams = array();
    protected $request;
    protected $response;
    protected $types    = array();
    protected $formatter	= array(
        'json' => 'jsonParams',
        'xml'  => 'xmlParams',
        'form' => 'formParams'
    );
    protected $parser	= array(
        'json' => 'parseJson',
        'xml'  => 'parseXml',
        'form' => 'parseForm'
    );
    /**
     * @var Client
     */
    private $client;

    private $params = array();

    public function __construct(){
        $this->request  = new Request();
        if(!empty($this->format))
            $this->setFormat($this->format);
        if(!empty($this->defaultParams))
            $this->setParams($this->defaultParams);
    }

    protected function getSignature($params=array()){
        $params = array_filter($params,'strlen');
        ksort($params);
        $params = array_values($params);
        array_unshift( $params , $this->client->getPassword() );
        $params = join('|',$params);
        return(sha1($params));
    }

    protected function parseJson( $json = '' ){
        $data = json_decode($json,TRUE);
        return $data['response'];
    }

    protected function parseXml( $xml = '' ){
        $xml = new XmlData($xml);
        $data = $xml->xmlToArray();
        return $data;
    }

    protected function parseForm($query=''){
        $data = array();
        parse_str($query, $data);
        return $data;
    }

    protected function parseRespose( $data ){
        $callback = $this->parser[$this->format];
        return call_user_func(array($this,$callback),$data);
    }
    protected function jsonParams($params=array()){
        return json_encode(array(
            'request'=>$params
        ));
    }
    protected function formParams($params=array()){
        return http_build_query($params);
    }
    private function xmlParams($params=array()){
        $xml = new XmlData('<request/>');
        $xml->arrayToXml($params);
        return $xml->asXML();
    }
    protected function buildParams($params){
        return call_user_func(array($this,$this->formatter[$this->format]),$params);
    }
    public function setClient(Client $client){
        $this->client = $client;
    }
    public function isValid($params){
        $fields = $this->fields;
        return true;
    }
    public function setPath($path){
        $this->path = $path;
        return $this;
    }
    public function setFormat($format){
        if( array_key_exists($format,$this->formatter) ){
            $this->format = $format;
            return TRUE;
        } else {
            $this->format = $this->defaultFormat;
            return FALSE;
        }
    }
    public function getFormat(){
        return $this->format;
    }
    public function isValidParam($key,$value){
        return TRUE;
    }
    public function setParams(array $params){
        if( $this->isValid($params) ){
            $this->params = array_merge($this->params,$params);
        }
        return $this;
    }
    public function setParam($key,$value){
        if( $this->isValidParam($key,$value) ){
            $this->params[$key] = $value;
        }
        return $this;
    }
    public function getParams(){
        $params = $this->params;
        $params['merchant_id'] = $this->client->getId();
        $params['signature']   = $this->getSignature($params);
        return $params;
    }
    public function getParam($key){
        return isset($this->params[$key]) ? $this->params[$key] : NULL;
    }
    public function getUrl(){
        return sprintf('%s%s',$this->client->getUrl(),$this->path);
    }
    public function call( array $params = array() ){
        $this->setParams( $params );
        $this->request->setFormat( $this->format );
        $data = $this->request->doPost($this->getUrl(),$this->buildParams($this->getParams()));
        $data = $this->parseRespose($data);
        $this->setResponse($data);
        return $this;
    }
    public function setResponse($data=array()){
        $this->response = new Response($data);
    }
    public function getResponse(){
        return $this->response;
    }
}