<?php
namespace WPMVC\Core;

/**
 * Controller Extendable
 */

class Controller{
    /**
     * Get View Contents
     * @param String $viewName
     */
    function view(String $viewName){
        return new \WPMVC\Views\ViewLoader($viewName);
    }

    /**
     * Redirect user
     * @param String $url
     */
    function redirect(String $url){
        \http_response_code(302);
        header("Location: ".$url);
        exit;
    }

}