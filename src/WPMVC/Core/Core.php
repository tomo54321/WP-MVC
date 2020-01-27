<?php
namespace WPMVC\Core;

use WPMVC\Core\Request\Request;
use WPMVC\Core\Bootstrap;
class Core{

    /**
     * Current Request Object
     */
    private $request;

    /**
     * New Instance
     */
    public function __construct(){
        $this->request = new Request();
    }

    public function request(){
        return $this->request;
    }

    /**
     * Get config file
     * @param String $cfgName
     * @return Array
     */
    public static function getConfig(String $cfgName){
        return Bootstrap::loadCFG($cfgName);
    }
}
