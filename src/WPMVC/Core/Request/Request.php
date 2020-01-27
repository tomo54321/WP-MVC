<?php
namespace WPMVC\Core\Request;
/**
 * Wordpress MVC Theme addon
 * Request Object
 * 
 * @author Tom Reeve <thomas.reeve@richardsonsgroup.net>
 * @copyright (c) 2020 Richardsons Leisure Ltd.
 */
class Request{

    public $headers;//Http Headers
    public $params = array("url"=>[], "cookies"=>[]);//Any submitted params

    /**
     * New Request instance
     */
    public function __construct(){
        $this->headers = $_SERVER;
        $this->params["url"]=array_merge($_GET, $_POST);
        $this->params["cookies"]=$_COOKIE;
    }

    /**
     * Get header
     * @param String $headerName
     * @return String
     */
    public function header(String $headerName){
        return isset($headers[$headerName])?$headers[$headerName]:null;
    }

    /**
     * Get request param
     * @param String $param
     * @return String
     */
    public function get(String $param){
        return isset($this->params["url"][$param])?$this->params["url"][$param]:null;
    }
}