<?php

namespace IpspPhp;

class Resource {
    /**
     * @var string
     */
    protected $method = 'POST';
    /**
     * @var string
     */
    protected $defaultFormat = 'json';
    /**
     * @var string
     */
    protected $format = 'json';
    /**
     * @var
     */
    protected $path;
    /**
     * @var array
     */
    protected $fields = array();
    /**
     * @var array
     */
    protected $defaultParams = array();
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Response
     */
    protected $response;
    /**
     * @var array
     */
    protected $types    = array();
    /**
     * @var array
     */
    protected $formatter	= array(
        'json' => 'jsonParams',
        'xml'  => 'xmlParams',
        'form' => 'formParams'
    );
    /**
     * @var array
     */
    protected $parser	= array(
        'json' => 'parseJson',
        'xml'  => 'parseXml',
        'form' => 'parseForm'
    );
    /**
     * @var Client
     */
    private $client;
    /**
     * @var array
     */
    private $params = array();

    /**
     * Resource constructor.
     */
    public function __construct(){
        $this->request  = new Request();
        if(!empty($this->format))
            $this->setFormat($this->format);
        if(!empty($this->defaultParams))
            $this->setParams($this->defaultParams);
    }

    protected function getSignature($params=array()){
        $signature = new Signature();
        $signature->merchant($this->client->getId());
        $signature->password($this->client->getPassword());
        return $signature->sign($params);
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
    public function isValidParam($key='',$value=''){
        $key;
        $value;
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
        return $this->getSignature($this->params);
    }
    public function getParam($key){
        return isset($this->params[$key]) ? $this->params[$key] : NULL;
    }
    public function getUrl(){
        return sprintf('%s%s',$this->client->getUrl(),$this->path);
    }
    /**
     * @param array $params
     * @return Resource $this
     */
    public function call( array $params = array() ){
        $this->setParams( $params );
        $this->request->setFormat( $this->format );
        $data = $this->request->doPost($this->getUrl(),$this->buildParams($this->getParams()));
        $data = $this->parseRespose($data);
        $this->setResponse($data);
        return $this;
    }
    /**
     * @param array $data
     * @return $this
     */
    public function setResponse($data=array()){
        $this->response = new Response($data);
        return $this;
    }
    /**
     * @return Response
     */
    public function getResponse(){
        return $this->response;
    }
}