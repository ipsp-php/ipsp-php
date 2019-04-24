<?php

namespace IpspPhp;

class Api
{
    private $client;
    private $params = array();
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Resource $resource
     * @param array $params
     * @return Resource
     */
    public function call(Resource $resource, array $params = array())
    {
        $params = array_merge($this->params, $params);
        $resource->setClient($this->client);
        $resource->call($params);
        return $resource;
    }
    public function setParam($key = '', $value = '')
    {
        $this->params[$key] = $value;
        return $this;
    }
    public function getParam($key = '')
    {
        return $this->params[$key];
    }
    public function hasAcsData()
    {
        return isset($_POST['MD']) AND isset($_POST['PaRes']);
    }
    public function getCurrentUrl()
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443);
            $protocol = $secure ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];
            $path = $_SERVER['REQUEST_URI'];
        } else {
            $protocol = 'http://';
            $host = 'localhost';
            $path = '/';
        }
        return $protocol . $host . $path;
    }
    public function hasResponseData()
    {
        return isset($_POST['response_status']);
    }
}