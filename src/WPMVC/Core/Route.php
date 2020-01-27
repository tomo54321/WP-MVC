<?php
namespace WPMVC\Core;
/**
 * Wordpress MVC Theme addon
 * 
 */

use WPMVC\Core\Request\Request;
use WPMVC\Core\Bootstrap;
class Route{

    /**
     * If get request is made
     * @param String $classname
     * @param String $function
     */
    public static function get(String $classname, String $function){

        if($_SERVER["REQUEST_METHOD"]!=="GET"){
            return;
        }

        $classrunname = "App\\Controllers\\".$classname;//Run class in App Namespace
        if(!class_exists($classrunname)){//Class doesn't exist?
            Bootstrap::loadController($classname.".php");
        }
        $pageRoute = new $classrunname;

        $response = $pageRoute->$function( new Request() );

        if($response instanceof \WPMVC\Views\ViewLoader){//Is a view, render it
            $response->__render( new Request() );
        }else{//If not display whatever it is.
            die( $pageRoute->$function( new Request() ) );
        }

    }

    /**
     * If post request is made
     * @param String $classname
     * @param String $function
     */
    public static function post(String $classname, String $function){
        if($_SERVER["REQUEST_METHOD"]!=="POST"){
            return;
        }
        
        $classrunname = "App\\Controllers\\".$classname;//Run class in App Namespace
        if(!class_exists($classrunname)){//Class doesn't exist?
            Bootstrap::loadController($classname.".php");
        }
        $pageRoute = new $classrunname;

        $response = $pageRoute->$function( new Request() );

        if($response instanceof \WPMVC\Views\ViewLoader){//Is a view, render it
            $response->__render( new Request() );
        }else{//If not display whatever it is.
            die( $pageRoute->$function( new Request() ) );
        }
    }

}
